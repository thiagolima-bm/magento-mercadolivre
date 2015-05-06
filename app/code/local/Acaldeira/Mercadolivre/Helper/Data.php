<?php
/**
 * Acaldeira Mercadolivre 
 * 
 * @category     Acaldeira
 * @package      Acaldeira_Mercadolivre 
 * @copyright    Copyright (c) 2015 MM (http://blog.meumagento.com.br/)
 * @author       MM (Thiago Caldeira de Lima)  
 * @version      Release: 0.1.0 
 */

require_once(Mage::getBaseDir('lib') . '/MercadoLivre/meli.php');
 
class Acaldeira_Mercadolivre_Helper_Data extends Mage_Core_Helper_Abstract
{


    public static function auth($code,$url)
    {

        // $url = Mage::getBaseUrl().'../mlapp.php';
         $session = self::getSession();


        if(isset($session['access_token'])){
            $meli = self::getMeli();
        }
        
        else{
            $session = array();
            $session['access_token'] = "";
            $session['expires_in'] = "";
            $session['refresh_token']  = "";
            $meli = self::getMeli();            
        }

        
        if($code || $session['access_token']) {

            // If code exist and session is empty
            if($code && !($session['access_token'])) {
                // If the code was in get parameter we authorize
                $user = $meli->authorize($code, $url);

                // var_dump($user);
                
                // Now we create the sessions with the authenticated user
                $session['access_token'] = $user['body']->access_token;
                $session['expires_in'] = time() + $user['body']->expires_in;
                $session['refresh_token'] = $user['body']->refresh_token;
            } else {
                // We can check if the access token in invalid checking the time
                if($session['expires_in'] < time()) {
                    try {
                        // Make the refresh proccess
                        $refresh = $meli->refreshAccessToken();

                        // Now we create the sessions with the new parameters
                        $session['access_token'] = $refresh['body']->access_token;
                        $session['expires_in'] = time() + $refresh['body']->expires_in;
                        $session['refresh_token'] = $refresh['body']->refresh_token;
                    } catch (Exception $e) {
                        echo "Exception: ",  $e->getMessage(), "\n";
                    }
                }
            }
            
            // $session['meli'] = $meli;

            Mage::getSingleton('admin/session')->setMLSession($session);  
            
        }
        

    }

    public static function saveProduct($_product,$mlProduct)
    {
        
        $session = self::getSession();

        if(isset($session['access_token']))
            $meli = self::getMeli();
        
            

        // We can check if the access token in invalid checking the time
        if($session['expires_in'] + time() + 1 < time()) {
            try {
                $meli->refreshAccessToken();
            } catch (Exception $e) {
                echo "Exception: ",  $e->getMessage(), "\n";
            }
        }
        
        $params = array('access_token' => $session['access_token']);

        $stockItem = Mage::getModel('cataloginventory/stock_item')
               ->loadByProduct($_product->getId());

        $_qty = self::checkQtyRules($stockItem['qty'],$mlProduct->getType());

        $_price = $_product->getPrice() + ($_product->getPrice() * Mage::getStoreConfig('mercadolivre/products/fee',Mage::app()->getStore()));

        $galleryData = $_product->getData('media_gallery');

        $cats = $_product->getCategoryIds();

        $extraDesc = Mage::getStoreConfig('mercadolivre/products/description',Mage::app()->getStore());

        $mlCat = Mage::getModel('mercadolivre/category')
                    ->getCollection()
                    ->addFieldToFilter('category_id',array('in'=>$cats))
                    ->getFirstItem();

        


        $pictures = array();
        foreach ($galleryData['images'] as &$image) {
                array_push($pictures, 
                    array(
                        'source' => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product'.$image['file']
                        )
                    );
        }

        $body = array(
                    "condition" => "new", 
                    "warranty" => "07 dias", 
                    "currency_id" => "BRL", 
                    "accepts_mercadopago" => true, 
                    "description" => $_product->getDescription() ."<p></p>". $extraDesc, 
                    "listing_type_id" => $mlProduct->getType(), 
                    "title" => substr($_product->getName(),0,59), 
                    "available_quantity" => $_qty, 
                    "price" => number_format($_price, 2, '.', ''), 
                    // "subtitle" => "Acompanha 3 Pares De Lentes!! Compra 100 Segura", 
                    "buying_mode" => "buy_it_now", 
                    "category_id" => ($mlCat->getMlcatId()) ? $mlCat->getMlcatId() : "MLB1341", 
                    "pictures" => $pictures
                );
      
        if($mlProduct->getMlId()){

            $body = array(
                    "title" => substr($_product->getName(),0,59),
                    "status"=>$mlProduct->getPublished(),
                    "price" => number_format($_price, 2, '.', ''), 
                    "available_quantity" => $_qty,  
                );

            $uri = '/items/'.$mlProduct->getMlId();
            return $meli->put($uri, $body, $params);

        }else{
            $uri = '/items';
            return $meli->post($uri, $body, $params);
        }
        
        

    }

    public static function uploadPictures($_product,$mlProduct)
    {
        
        $session = self::getSession();

        if(isset($session['access_token']))
            $meli = self::getMeli();
        
            

        // We can check if the access token in invalid checking the time
        if($session['expires_in'] + time() + 1 < time()) {
            try {
                $meli->refreshAccessToken();
            } catch (Exception $e) {
                echo "Exception: ",  $e->getMessage(), "\n";
            }
        }
        
        $params = array('access_token' => $session['access_token']);

        $galleryData = $_product->getData('media_gallery');

        $pictures = array();
        foreach ($galleryData['images'] as &$image) {
                array_push($pictures, 
                    array(
                        'source' => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product'.$image['file']
                        )
                    );
        }

        $body = array("pictures" => $pictures);
      
        if($mlProduct->getMlId()){

            $uri = '/items/'.$mlProduct->getMlId();
            return $meli->put($uri, $body, $params);

        }
        
        

    }

    public static function checkQtyRules($qty,$type)
    {

        switch ($type) {
            case 'free':
                $_qty = 1;
                break;
            
            default:
                $_qty = $qty;
                break;
        }
        return $_qty;
    }


    public static function getLoginUrl($url)
    {
        $url = Mage::helper('adminhtml')->getUrl('mercadolivre/adminhtml_mercadolivre/*');
        $meli = self::getMeli();
        return $meli->getAuthUrl($url);
    }
   
    public static function isLogged()
    {
        $session = self::getSession();

        if(!$session['access_token'])
            return false;
        else{

            if($session['expires_in'] < time()) {
                    try {

                        $meli = self::getMeli();
                        // Make the refresh proccess
                        $refresh = $meli->refreshAccessToken();

                        // Now we create the sessions with the new parameters
                        $session['access_token'] = $refresh['body']->access_token;
                        $session['expires_in'] = time() + $refresh['body']->expires_in;
                        $session['refresh_token'] = $refresh['body']->refresh_token;
                    } catch (Exception $e) {
                        echo "Exception: ",  $e->getMessage(), "\n";
                    }
                }
            return true;
        }
        
    }

    public static function getMeli()
    {
        $session = self::getSession();
        
        if(isset($session['access_token'])){
            $meli = new Meli(
                Mage::getStoreConfig('mercadolivre/general/app_id',Mage::app()->getStore()),
                Mage::getStoreConfig('mercadolivre/general/secret_key',Mage::app()->getStore()), 
                $session['access_token'], 
                $session['refresh_token']);
        }else{
            $meli = new Meli(
                Mage::getStoreConfig('mercadolivre/general/app_id',Mage::app()->getStore()), 
                Mage::getStoreConfig('mercadolivre/general/secret_key',Mage::app()->getStore()));
        }
        
        return $meli;
    }

    public static function getSession()
    {
        return  Mage::getSingleton('admin/session')->getMLSession();
    }
 
}
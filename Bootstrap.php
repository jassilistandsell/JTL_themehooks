<?php declare(strict_types=1);

namespace Template\LSdeinefutterwelt;
use JTL\Catalog\Product\Artikel;
use JTL\Catalog\Category\KategorieListe;
use JTL\Filter\ProductFilter;
use JTL\Session\Frontend;
use JTL\Filter\Config;
use JTL\Events\Dispatcher;

use JTL\Helpers\Text;
use JTL\Helpers\Product;
use JTL\Helpers\Category;
use JTL\Cart\CartHelper;
use JTL\Catalog\Product\EigenschaftWert;
use JTL\Catalog\Product\Preise;
use JTL\Helpers\GeneralObject;

use JTL\Shop;
use Smarty;
/**
 * Class Bootstrap
 * @package Template\NOVAChild
 */
class Bootstrap extends \Template\NOVA\Bootstrap
{
    /**
     * @inheritdoc
     */


    public function boot(): void
    {
        parent::boot();
    
    }



    protected function registerPlugins(): void
    {
        parent::registerPlugins();
        $smarty = $this->getSmarty();
        if ($smarty === null) {
            return;
        }
        $plugins        = new Plugins($this->getDB(), $this->getCache());

        try{
            $smarty->registerPlugin(Smarty::PLUGIN_FUNCTION, 'ls_search_regex', [$plugins, 'ls_search_regex'])
                    ->registerPlugin(Smarty::PLUGIN_FUNCTION, 'ls_localize_price', [$plugins, 'ls_localize_price']) //---
                  ->registerPlugin(Smarty::PLUGIN_FUNCTION, 'sanitize_string', [$plugins, 'sanitize_string'])// -- Cross selling
                  ->registerPlugin(Smarty::PLUGIN_FUNCTION, 'suburl', [$plugins, 'suburl']); 
                
    

            // DISPATCHER FUNCTIONS
            $dispatcher = Dispatcher::getInstance();
               
        /**
        * 
        * AJAX REQUESTS
        * 
        */
      
        $listenTo = [
            \HOOK_SMARTY_OUTPUTFILTER,
            \HOOK_IO_HANDLE_REQUEST,
        ];
        foreach ($listenTo as $hook) {
            $dispatcher->listen('shop.hook.' . $hook, [$plugins, 'lsexec']);
        }
           
          

        }catch (\SmartyException $e) {
            throw new \RuntimeException('Problems during smarty instantiation: ' . $e->getMessage());
        }

       
    }
    public function getPluginConfig($params = null){
        return $plugin->getConfig();
    }

}
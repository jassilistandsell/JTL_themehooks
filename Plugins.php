<?php declare(strict_types=1);

namespace Template\LSdeinefutterwelt;

use Illuminate\Support\Collection;
use JTL\Cache\JTLCacheInterface;
use JTL\Catalog\Category\Kategorie;
use JTL\Catalog\Category\KategorieListe;
use JTL\Catalog\Product\Artikel;
use JTL\Catalog\Product\Preise;
use JTL\Catalog\Product\VariationValue;
use JTL\CheckBox;
use JTL\DB\DbInterface;
use JTL\Filter\Config;
use JTL\Filter\ProductFilter;
use JTL\Helpers\Category;
use JTL\Helpers\Manufacturer;
use JTL\Helpers\Seo;
use JTL\Helpers\Tax;
use JTL\Link\Link;
use JTL\Link\LinkGroupInterface;
use JTL\Media\Image;
use JTL\Media\Image\Product;
use JTL\Media\MultiSizeImage;
use JTL\Session\Frontend;
use JTL\Shop;
use JTL\Staat;
use Smarty_Internal_Template;
use JTL\Catalog\Product\EigenschaftWert;
use JTL\Helpers\Text;
use JTL\Cart\CartHelper;
use JTL\Helpers\GeneralObject;
use stdClass;
use function Functional\first;

/**
 * Class Plugins
 * @package Template\LSdeinefutterwelt
 */
class Plugins
{
    /**
     * @var DbInterface
     */
    private DbInterface $db;


    /**
     * @var JTLCacheInterface
     */
    private JTLCacheInterface $cache;

    private $shopUrl;
    /**
     * Plugins constructor.
     * @param DbInterface       $db
     * @param JTLCacheInterface $cache
     */
    public function __construct(DbInterface $db, JTLCacheInterface $cache)
    {
        $this->db    = $db;
        $this->cache = $cache;
        $this->shopUrl = SHOP::getUrl();
    }

    /**
     * @param array                    $params
     * @param Smarty_Internal_Template $smarty
     * @return array|void
     */
 

     
    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * SHOP HOOKS
     * 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
     // HOOK_SMARTY_OUTPUTFILTER 
     public function lsexec(array $args): void
     {   
         // Add below header text
         $this->addtimeinterval($args);
        
     }
     public function addtimeinterval()
     {
        $db = Shop::Container()->getDB();
     
         // Fetch existing frequencies and coupons from the database
         $query = 'SELECT kFrequency, cFrequency, cFreq_coupon FROM tfrequency';
        $existingFrequencies = $db->getObjects($query);

        error_log(print_r($existingFrequencies, true));

         $frequencies = [];
         if (!empty($existingFrequencies)) {
            foreach ($existingFrequencies as $entry) {
             $frequencies[] = [
                 'kFrequency' => $entry->kFrequency,
                 'frequency'  => $entry->cFrequency,
                 'coupon'     => $entry->cFreq_coupon
             ];
         }
        }
     
         // Debug: Log processed data to check if it's being processed correctly
        error_log(print_r($frequencies, true));


         // Get the Smarty instance
         $smarty = Shop::Smarty();
     
         // Check if the Smarty instance is valid
         if ($smarty !== null) {
             // Assign data to Smarty
           $freq_abo =  $smarty->assign('frequencies', $frequencies)
             ->fetch('snippets/ls/frequency_abo.tpl');
             pq('body .sub_abbo_weeks')->html($freq_abo); 
          
             // Optionally, log or handle $output if you need to process it further
             // For example, you can return it or print it if needed:
             // echo $output;
         } else {
             error_log('Smarty instance is null.');
         }
     }
     
    }
  
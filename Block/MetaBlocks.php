<?php
namespace Risecommerce\StructuredData\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface; 
use Magento\Framework\View\Page\Title;
use Magento\Framework\View\Page\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;

class MetaBlocks extends \Magento\Framework\View\Element\Template
{
	const TWITTER_IMAGE = 'structureddata/twitter_meta_share_options/twitter_default_image';
    const TWITTER_USERNAME = 'structureddata/twitter_meta_share_options/twitter_username';
    const FACEBOOK_USERNAME = 'structureddata/facebook_meta_share_options/facebook_username';
    const INSTAGRAM_USERNAME = 'structureddata/instagram_meta_share_options/instagram_username';
    const TWITTER_ENABLED = 'structureddata/twitter_meta_share_options/enable_disable_twitter_tags';

    const FACEBOOK_IMAGE = 'structureddata/facebook_meta_share_options/facebook_default_image';
    const FACEBOOK_ENABLED = 'structureddata/facebook_meta_share_options/enable_disable_facebook_tags';

    
    const INSTAGRAM_IMAGE = 'structureddata/instagram_meta_share_options/instagram_default_image';
    const INSTAGRAM_ENABLED = 'structureddata/instagram_meta_share_options/enable_disable_instagram_tags';

    const PREFIX = 'structureddata/additional_settings/prefix';
    const POSTFIX = 'structureddata/additional_settings/postfix';

    const STORE_NAME = 'general/store_information/name';

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Title
     */
    protected $pageTitle;

    /**
     * @var Config
     */
    protected $pageDescription;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;


    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var UrlInterface
     */
    protected $urlInterface;


    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param Title $pageTitle
     * @param Config $pageDescription
     * @param ScopeConfigInterface $scopeConfig
     * @param Registry $registry
     * @param UrlInterface $urlInterface
     */
	public function __construct(
		Context $context,
        StoreManagerInterface $storeManager,
        Title $pageTitle,
        Config $pageDescription,
        ScopeConfigInterface $scopeConfig,
        Registry $registry,
        UrlInterface $urlInterface
	)
	{
		$this->storeManager = $storeManager;
        $this->pageTitle = $pageTitle;
        $this->pageDescription = $pageDescription;
        $this->scopeConfig = $scopeConfig;
        $this->registry = $registry;
        $this->urlInterface = $urlInterface;

		parent::__construct($context);
	}

	/**
     * Return current URL
     *
     * @return string
     */
    public function getPageUrl()
    {
        /* @phpstan-ignore-next-line */
        $storeUrl = $this->urlInterface->getCurrentUrl();

        return $storeUrl;
    }

    /**
     * Get Page Title
     *
     * @return mixed
     */
    public function getPageTitle()
    {
        // var_dump(get_class_methods($this->pageTitle()));
        $title = $this->pageTitle->getShort();

        return $title;
    }

    /**
     * Get Page Title
     *
     * @return string
     */
    public function getPageDescription()
    {
        $description = $this->pageDescription->getDescription();

        return $description;
    }

    /**
     * Facebook enabled?
     *
     * @return mixed
     */
    public function facebookEnabled()
    {
        return $this->getConfig(self::FACEBOOK_ENABLED);
    }

     /**
     * Instagram enabled?
     *
     * @return mixed
     */
    public function instagramEnabled()
    {
        return $this->getConfig(self::INSTAGRAM_ENABLED);
    }

    /**
     * Twitter enabled?
     *
     * @return mixed
     */
    public function twitterEnabled()
    {
        return $this->getConfig(self::TWITTER_ENABLED);
    }


    /**
     * Get Twitter Image
     *
     * @return string
     */
    public function getTwitterImage()
    {
        return $this->getConfig(self::TWITTER_IMAGE);
    }

    /**
     * Get Facebook Image
     *
     * @return string
     */
    public function getFacebookImage()
    {
        return $this->getConfig(self::FACEBOOK_IMAGE);
    }

    
    /**
     * Get Instagram Image
     *
     * @return string
     */
    public function getInstagramImage()
    {
        return $this->getConfig(self::INSTAGRAM_IMAGE);
    }

    /**
     * @param string $configPath
     * @return string
     */
    public function getConfig($configPath)
    {
        return strval($this->scopeConfig->getValue(
            $configPath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        ));
    }


    /**
     * Get Store Name
     *
     * @return string
     */
    public function getStoreName()
    {
        return $this->getConfig(self::STORE_NAME);
    }


    /**
     * Get current product main image
     *
     * @return string
     */
    public function getCurrentProductImage():string
    {
        $product = $this->registry->registry('current_product');

        if(strval($product->getData('image')) !== "no_selection") /** @phpstan-ignore-line */
        {
            $productImage = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . "catalog/product" . strval($product->getData('image')); /** @phpstan-ignore-line */
        }
        else
        {
            $productImage = "";
        }

        return $productImage;
    }


    /**
     * Get Twitter Username
     *
     * @return string
     */
    public function getTwitterAccount()
    {
        return $this->getConfig(self::TWITTER_USERNAME);
    }

    
    /**
     * Get Twitter Username
     *
     * @return string
     */
    public function getFacebookAccount()
    {
        return $this->getConfig(self::FACEBOOK_USERNAME);
    }

    
    /**
     * Get Twitter Username
     *
     * @return string
     */
    public function getInstagramAccount()
    {
        return $this->getConfig(self::INSTAGRAM_USERNAME);
    }


    /**
     * Get Twitter Username
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->getConfig(self::PREFIX);
    }

        /**
     * Get Twitter Username
     *
     * @return string
     */
    public function getPostfix()
    {
        return $this->getConfig(self::POSTFIX);
    }

}

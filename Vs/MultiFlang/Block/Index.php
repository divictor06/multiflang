<?php

namespace Vs\MultiFlang\Block;

use Magento\Framework\View\Element\Template;

class Index extends Template {

    protected $storeManager;

    protected $locale;

    protected $page;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Locale\Resolver $locale,
        \Magento\Cms\Model\Page $page,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->locale  = $locale;
        $this->page = $page;
        parent::__construct($context, $data);
    }

    public function getUrlStore($store){

        return $this->storeManager->getStore($store)->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
    }

    public function getStoresPage(){
        return $this->page->getStores();
    }

    public function getUrlPage(){
        return $this->page->getIdentifier();
    }

    public function getStoreCount($store)
    {
       return $this->locale->emulate($store);
    }

    public function isActive(){
        return $this->page->isActive();
    }

    public function links(){

        $stores = $this->page->getStores();
        $links = '';

        foreach ($stores as $key => $value) {
            $storeLanguage = $this->getStoreCount($value);
            $baseUrl = $this->getUrlStore($value);
            $cmsPageUrl = $this->getUrlPage();

            $links .= '<link rel="alternate" hreflang="' . $storeLanguage . '" href="' . $baseUrl . $cmsPageUrl . '" />';
        }

        return $links;

    }

}
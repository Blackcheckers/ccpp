<?php
namespace CCPP\Coupang;
use Symfony\Component\DomCrawler\Crawler;

class Template{

    public $html;
    public $cwl;

    public function __construct(Crawler $cwl, $html='')
    {
        $this->cwl = $cwl;
        $this->html = $html;
    }

    public function setHtml($html)
    {
        $this->html = $html;
        $this->cwl->add($this->html);
        return $this;
    }

    public function getHtml($html)
    {
        return $this->html;
    }

    public function getContents()
    {
        $foo = $this->getEssentialInfo();
        $data = [
            'essentialInfo' => $this->getEssentialInfo()->count() > 0 ? $this->getEssentialInfo()->outerHtml() : '',
            'detail'        => $this->getDetail()->count() > 0 ? $this->getDetail()->outerHtml() : '',
            'review'        => $this->getReview()->count() > 0 ? $this->getReview()->outerHtml() : '',
        ];

        return $data;
    }

    public function getEssentialInfo()
    {
        $element = $this->cwl->filter('.prod-delivery-return-policy-table');
        return $element;
    }

    public function getDetail()
    {
        $element = $this->cwl->filter('#productDetail');
        return $element;
    }

    public function getReview()
    {
        $element = $this->cwl->filter('.product-review');
        return $element;
    }
}

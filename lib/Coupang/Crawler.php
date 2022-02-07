<?php
namespace CCPP\Coupang;
use Symfony\Component\DomCrawler\Crawler as cwl;

class Crawler{
    public static $cwl;

    public function __construct(cwl $cwl)
    {
        $this->cwl = $cwl;
    }

    public function getPageSource(string $url)
    {
//        $cmd = 'docker run -i --rm --name my-running-script -v /Users/jisungyoo/Dev/docker/docker_php8_laravel/public_html/ccpp:/usr/src/myapp -w /usr/src/myapp jisung87kr/ubuntu:selenium python3 crawler.py';
        $cmd = "python3 /var/www/html/ccpp/python/crawler.py $url";
        $output = shell_exec('RET=`'.$cmd.'`;echo $RET');
        $this->cwl->add($output);
        return $this->cwl;
    }

}
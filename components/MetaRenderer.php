<?php
namespace app\components;

use app\models\Beallitasok;
use app\models\Fajl;
use app\models\Hir;
use app\models\Kategoria;
use app\models\StatikusOldal;
use app\models\Termek;
use Yii;
use ZendSearch\Lucene\Index\Term;

class MetaRenderer {
    const DEFAULT_TITLE = 'DragCards';

    const DEFAULT_DESCRIPTION = 'Okoskártyák különféle felhasználáshoz';

    const DEFAULT_ROBOTS = 'noarchive,max-snippet:-1,max-image-preview:standard,max-video-preview:-1';
    CONST DEFAULT_ROBOTS_OTHER = 'noindex,nofollow,max-snippet:-1,max-image-preview:standard,max-video-preview:-1';

    private $actionId;

    function __construct($actionId) {
        $this->actionId = $actionId;
    }

    private function getDefaultTitle() {
        return self::DEFAULT_TITLE;
    }

    private function getDefaultImage() {
        return '/img/meta.png';
    }

    private function renderMetaByData($data = []) {
        $lang = Lang::$current;
        $domainProp = 'domain_' . $lang;
        $url = Helpers::rootUrl() . '/' . Yii::$app->request->pathInfo;

        $title = htmlspecialchars(($data['title'] ?? null) ?: self::DEFAULT_TITLE ?: '', ENT_QUOTES, 'UTF-8');
        $robots = htmlspecialchars(($data['robots'] ?? null) ?: self::DEFAULT_ROBOTS ?: '', ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars(($data['description'] ?? null) ?: '', ENT_QUOTES, 'UTF-8');
        $locale = htmlspecialchars(($data['locale'] ?? null) ?: $lang ?: '', ENT_QUOTES, 'UTF-8');

        $EOF = "\n";
        $meta = '<title>' . $title . '</title>' . $EOF;
        $meta .= '<meta name="robots" content="' . $robots . '" />' . $EOF;
        $meta .= '<meta name="og:title" content="' . $title . '" />' . $EOF;
        if ($description) {
            $meta .= '<meta name="description" content="' . $description . '" />' . $EOF;
            $meta .= '<meta name="og:description" content="' . $description . '" />' . $EOF;
        }
        $meta .= '<meta name="og:locale" content="' . $lang . '" />' . $EOF;
        $meta .= '<meta name="og:type" content="website" />' . $EOF;
        $meta .= '<meta name="og:url" content="' . $url . '" />' . $EOF;
        $meta .= '<link rel="canonical" href="' . $url . '" />' . $EOF;

        if ($data['image'] ?? null) {
            $imageUrl = $data['image'];
            if (substr($imageUrl, 0, 4) != 'http') {
                $imageUrl = Helpers::rootUrl() . $imageUrl;
            }
            $meta .= '<meta name="og:image" content="' . $imageUrl . '" />' . $EOF;
        }

        return $meta;
    }

    public function render() {
        switch ($this->actionId) {
            case 'site/index':
                return $this->renderMetaByData([
                    'title' => self::DEFAULT_TITLE,
                    'description' => self::DEFAULT_DESCRIPTION,
                    'image' => '/img/meta.png',
                ]);

            case 'site/product':
                $id = Yii::$app->request->get('id');
                $product = Termek::findOne($id);

                if (!$product) {
                    return '';
                }

                return $this->renderMetaByData([
                    'title' => $product->nev . ' | ' . self::DEFAULT_TITLE,
                    'description' => $product->rovid_leiras,
                    'image' => $product->photo ? '/' . $product->photo->getFilePath() : '/img/meta.png',
                ]);

            case 'site/static-page':
                $id = Yii::$app->request->get('id');
                $staticPage = StatikusOldal::findOne($id);

                return $this->renderMetaByData([
                    'title' => $staticPage->cim . ' ' . self::DEFAULT_TITLE,
                    'description' => '',
                    'image' => '/img/meta.png',
                ]);

            case 'site/blog-post':
                $id = Yii::$app->request->get('id');
                $blogPost = Hir::findOne($id);

                return $this->renderMetaByData([
                    'title' => $blogPost->cim . ' ' . self::DEFAULT_TITLE,
                    'description' => $blogPost->bevezeto,
                    'image' => $blogPost->photo ? '/' . $blogPost->photo->getFilePath() : '/img/meta.png',
                ]);

            case 'site/category':
                $id = Yii::$app->request->get('id');
                $category = Kategoria::findOne($id);

                if (!$category) {
                    return $this->renderMetaByData([
                        'title' => self::DEFAULT_TITLE,
                        'description' => self::DEFAULT_DESCRIPTION,
                        'image' => '/img/meta.png',
                    ]);
                }

                return $this->renderMetaByData([
                    'title' => $category->nev . ' | ' . self::DEFAULT_TITLE,
                    'description' => '',
                    'image' => $category->photo ? '/' . $category->photo->getFilePath() : '/img/meta.png',
                ]);

            default:
                // Other pages
                // No index, no follow

                return $this->renderMetaByData([
                    'title' => $this->getDefaultTitle(),
                    'robots' => self::DEFAULT_ROBOTS_OTHER,
                    'image' => $this->getDefaultImage(),
                ]);
        }
    }
}


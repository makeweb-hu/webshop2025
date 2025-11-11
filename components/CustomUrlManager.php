<?php

namespace app\components;
use app\models\Oldal;
use app\models\StatikusOldal;
use yii;
use \yii\web\UrlManager;
use yii\web\UrlRule;

class CustomUrlManager extends UrlManager {

    public $rules = [];

    public function parseRequest($request) {

        // HANDLE LANGUAGES

        /*

        $domainParts = explode(".", $request->hostName);

        if (count($domainParts) === 2) {
            Lang::$current = Lang::$default;
        }

        if (count($domainParts) === 3) {
            if (!Lang::isValidLang($domainParts[0])) {
                throw new yii\web\HttpException(404);
            }
            Lang::$current = $domainParts[0];
        }

        if (count($domainParts) > 3 || count($domainParts) == 1) {
            throw new yii\web\HttpException(404);
        }

        // HANDLE SLUGS

        $path = Yii::$app->request->pathInfo;

        $staticPage = StatikusOldal::findOne([ 'slug_hu' => $path ]);

        if ($staticPage) {
            return [
                "site/static-page",
                [
                    "id" => $staticPage->getPrimaryKey(),
                ]
            ];
        }

        */

        $path = Yii::$app->request->pathInfo;
        $page = Oldal::findOne(['url' => $path]);

        if ($page) {
            switch ($page->tipus) {
                case 'termek':
                    return [
                        "site/product",
                        [
                            "id" => $page->model_id,
                        ]
                    ];
                case 'kategoria':
                    return [
                        "site/category",
                        [
                            "id" => $page->model_id,
                        ]
                    ];
                case 'statikus_oldal':
                    return [
                        "site/static-page",
                        [
                            "id" => $page->model_id,
                        ]
                    ];
                case 'hir':
                    return [
                        "site/blog-post",
                        [
                            "id" => $page->model_id,
                        ]
                    ];
                case 'atiranyitas':
                    return [
                        "site/redirect-to",
                        [
                            "where" => $page->hova,
                            "statusCode" => $page->atiranyitas_statusz,
                        ]
                    ];
            }
        }

        return parent::parseRequest($request);

    }


}

?>
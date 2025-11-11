<?php
namespace app\controllers;

use app\components\Stripe\Order;
use app\components\Szamlazz;
use app\models\Beallitasok;
use app\models\Bejelentkezes2fa;
use app\models\Dashboard;
use app\models\DashboardKartya;
use app\models\EmailSablon;
use app\models\Felhasznalo;
use app\models\Hir;
use app\models\HirKategoria;
use app\models\Job;
use app\models\Kategoria;
use app\models\Kerdoiv;
use app\models\Kosar;
use app\models\Orszag;
use app\models\StatikusOldal;
use app\models\Szamla;
use app\models\Termek;
use app\models\Tudastar;
use app\models\TudastarFejezet;
use app\models\Uzenet;
use app\models\Vasarlo;
use Yii;
use ZendSearch\Lucene\Index\Term;

class AdminController extends \yii\web\Controller {
    public $enableCsrfValidation = false;

    public function beforeAction($action) {
        $this->layout = "@app/themes/main/layouts/admin";

        $user = Felhasznalo::current();

        // Csak az itt felsorolt action-ök a publikusak
        if (!$user && $action->id !== "login" && $action->id !== "index" && $action->id !== "2fa") {
            $this->redirect('/admin');
            return false;
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;
    }

    public function actionIndex() {
        if (!Felhasznalo::current()) {
            return $this->redirect('/admin/login');
        }
        if (!Felhasznalo::current()->isModerator()) {
            return $this->redirect('/admin');
        }
        return $this->redirect('/admin/dashboard');
    }

    public function actionDashboard() {
        return $this->render('pages/dashboard');
    }


    public function actionSchedules()
    {
        return $this->render('tables/schedules_table');
    }

    public function actionContentTable($type) {
        return $this->render('tables/content-table', [
            'type' => $type,
        ]);
    }


    public function actionNews() {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('tables/news_table');
    }

    public function actionRedirectToNews($id) {
        $article = Hir::findOne($id);
        if (!$article) {
            return $this->redirect('/');
        }
        return $this->redirect($article->getUrl());
    }

    public function actionRedirectToNewsCategory($id) {
        $category = HirKategoria::findOne($id);
        if (!$category) {
            return $this->redirect('/');
        }
        return $this->redirect($category->getUrl());
    }

    public function actionNewsCategories() {
        /*
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('tables/news_categories_table');
        */
    }

    public function actionEditNews($id = '') {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        $model = Hir::findOne($id);
        if (!$model) {
            $id = '';
        }
        return $this->render('forms/edit_news', [
            'id' => $id,
        ]);
    }

    public function actionEditNewsSeo($id = '') {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        $model = Hir::findOne($id);
        if (!$model) {
            $id = '';
        }
        return $this->render('forms/edit_news_seo', [
            'id' => $id,
        ]);
    }

    public function actionQuestions() {
        return $this->render('tables/questions_table');
    }

    public function actionSliders() {
        return $this->render('tables/sliders');
    }


    public function actionQuestion($id) {
        $model = Kerdoiv::findOne($id);
        return $this->render('tables/question_table', [
            'model' => $model,
        ]);
    }

    public function actionSubcards($id) {
        $model = DashboardKartya::findOne($id);
        return $this->render('pages/subcards', [
            'model' => $model,
        ]);
    }

    public function actionChapter($id) {
        $model = TudastarFejezet::findOne($id);
        return $this->render('pages/chapter', [
            'model' => $model,
        ]);
    }

    public function actionMessage($id) {
        $model = Uzenet::findOne($id);
        return $this->render('pages/message', [
            'model' => $model,
        ]);
    }

    public function actionApi() {
        return $this->render('pages/api', [

        ]);
    }

    public function actionMessages() {
        return $this->render('pages/messages', [

        ]);
    }

    public function actionProducts() {
        return $this->render('pages/products', [

        ]);
    }

    public function actionArticle($id) {
        $model = Tudastar::findOne($id);
        return $this->render('pages/article', [
            'model' => $model,
        ]);
    }

    public function actionArticles() {
        return $this->render('pages/articles', [

        ]);
    }

    public function actionOnboarding() {
        return $this->render('tables/onboarding_table');
    }

    public function actionUsers() {
        if (!Felhasznalo::current()->isSuperadmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('tables/users_table');
    }

    public function actionUser($id) {
        if (!Felhasznalo::current()->isSuperadmin()) {
            return $this->redirect('/admin');
        }
        $model = Felhasznalo::findOne($id);
        if (!$model) {
            return $this->redirect('/admin');
        }
        return $this->render('pages/user_page', [
            'model' => $model,
        ]);
    }

    public function actionOwnActivity() {
        return $this->render('tables/own_activity', [

        ]);
    }

    public function actionUserLogs() {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('tables/user_logs', [

        ]);
    }

    public function actionJobs() {
        if (!Felhasznalo::current()->isModerator()) {
            return $this->redirect('/admin');
        }
        return $this->render('tables/jobs_table', [

        ]);
    }

    public function actionPages() {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('tables/pages_table', [

        ]);
    }

    public function actionEditPage($id = '') {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('forms/edit_page', [
            'id' => $id,
        ]);
    }

    public function actionTexts($id = '') {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('tables/texts_table', [
            'id' => $id,
        ]);
    }

    public function actionMasterData($id = '') {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('tables/master_data_table', [
            'id' => $id,
        ]);
    }

    public function actionEmailTemplates($id = '') {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('settings/email_templates', [
            'id' => $id,
        ]);
    }

    public function actionGetInvoicePdf($id) {
        $model = Szamla::findOne($id);

        return Yii::$app->response->sendFile('storage/szamlazzhu/pdf/' . $model->bizonylatszam . '.pdf');
    }

    public function actionEditEmailTemplate($id = '') {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('settings/edit_email_template', [
            'id' => $id,
        ]);
    }

    public function actionEmailTemplatePreview($id = '') {
        return $this->render('forms/email_template_preview', [
            'id' => $id,
        ]);
    }

    public function actionEmailPreview($id = '') {
        $template = EmailSablon::findOne($id);
        $raw = $template->getRaw();

        $html = $template->renderBody($template->testData());

        $this->layout = false;
        return $this->render('email_preview', [
            'html' => $html,
        ]);
    }

    public function actionOrderPrint($id = '') {
        $order = Kosar::findOne($id);

        $template = EmailSablon::findOne(6);
        $raw = $template->getRaw();

        $data = $order->getDataForEmailTemplate();

        $html = $template->renderBody($data);

        foreach (['Szállítási cím', 'Számlázási cím', 'Vásárló adatai', 'Szállítási mód', 'Fizetési mód', 'Megjegyzés'] as $label) {
            $html = str_replace($label, '<br>' . $label, $html);
        }

        $this->layout = false;
        return $this->render('email_preview', [
            'html' => $html,
            'print_mode' => true,
        ]);
    }

    public function actionContact() {
        return $this->render('contact', [

        ]);
    }

    public function actionContactPage($id) {
        return $this->render('contact_page', [
            'id' => $id,
        ]);
    }

    public function actionSettingsSmtp() {
        return $this->render('settings/smtp', [
            'model' => Beallitasok::findOne(1),
        ]);
    }

    public function actionSettingsEmailTemplate() {
        return $this->render('settings/email_template', [
            'model' => Beallitasok::findOne(1),
        ]);
    }

    public function actionCoupons() {
        return $this->render('tables/coupons', [

        ]);
    }

    public function actionPromotions() {
        return $this->render('tables/promotions', [

        ]);
    }

    public function actionMaintenance() {
        return $this->render('settings/maintenance', [
            'model' => Beallitasok::findOne(1),
        ]);
    }

    public function actionStaticPages() {
        return $this->render('tables/static_pages', [

        ]);
    }

    public function actionEditStaticPage($id = null) {
        return $this->render('forms/edit_static_page', [
            'id' => $id,
        ]);
    }

    public function actionEditStaticPageMeta($id = null) {
        return $this->render('forms/edit_static_page_meta', [
            'id' => $id,
        ]);
    }

    public function actionViewStaticPage($id) {
        $model = StatikusOldal::findOne($id);
        if ($model && $model->page) {
            return $this->redirect('/' . $model->page->url);
        }

        return $this->redirect('/admin/static-pages');
    }

    public function actionViewProduct($id) {
        $model = Termek::findOne($id);
        if ($model && $model->page) {
            return $this->redirect('/' . $model->page->url);
        }

        return $this->redirect('/admin/static-pages');
    }

    public function actionViewCategory($id) {
        $model = Kategoria::findOne($id);
        if ($model && $model->page) {
            return $this->redirect('/' . $model->page->url);
        }

        return $this->redirect('/admin/category');
    }

    public function actionCustomers() {
        return $this->render('pages/customers', [

        ]);
    }

    public function actionCustomer($id) {
        return $this->render('pages/customer', [
            'model' => Vasarlo::findOne($id),
        ]);
    }

    public function actionCategories() {
        return $this->render('tables/categories', [

        ]);
    }

    public function actionAttributes() {
        return $this->render('tables/attributes', [

        ]);
    }

    public function actionOrders() {
        return $this->render('pages/orders', [

        ]);
    }

    public function actionEditCategory($id = '') {
        return $this->render('pages/edit_category', [
            'id' => $id,
        ]);
    }

    public function actionEditProduct($id = '') {
        return $this->render('pages/edit_product', [
            'id' => $id,
        ]);
    }

    public function actionEditProductMeta($id = '') {
        return $this->render('pages/edit_product_meta', [
            'id' => $id,
        ]);
    }

    public function actionEditProductAttributes($id = '') {
        return $this->render('pages/edit_product_attributes', [
            'id' => $id,
        ]);
    }

    public function actionEditProductVariations($id = '') {
        return $this->render('pages/edit_product_variations', [
            'id' => $id,
        ]);
    }

    public function actionEditAttribute($id = '') {
        return $this->render('pages/edit_attribute', [
            'id' => $id,
        ]);
    }

    public function actionEditCategoryMeta($id = '') {
        return $this->render('pages/edit_category_meta', [
            'id' => $id,
        ]);
    }

    public function actionSettingsSms() {
        return $this->render('settings/sms', [
            'model' => Beallitasok::findOne(1),
        ]);
    }

    public function actionSettingsUrls() {
        return $this->render('settings/urls', [
            'model' => Beallitasok::findOne(1),
        ]);
    }

    public function actionSettingsShipping() {
        return $this->render('settings/shipping', [
            'model' => Beallitasok::findOne(1),
        ]);
    }

    public function actionSettingsPayments() {
        return $this->render('settings/payments', [
            'model' => Beallitasok::findOne(1),
        ]);
    }

    public function actionSettingsInvoice() {
        return $this->render('settings/invoice', [
            'model' => Beallitasok::findOne(1),
        ]);
    }

    public function actionSettings($tab = 'general') {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('settings/' . $tab, [
            'model' => Beallitasok::findOne(1),
            'tab' => $tab,
        ]);
    }

    public function actionEditPageSeo($id = '') {
        if (!Felhasznalo::current()->isAdmin()) {
            return $this->redirect('/admin');
        }
        return $this->render('forms/edit_page_seo', [
            'id' => $id,
        ]);
    }

    public function actionGoToPage($id) {
       $this->redirect('/' . StatikusOldal::findOne($id)->slug_hu);
    }

    public function actionSettingsGeneral() {
        return $this->render('settings/general', [
            'model' => Beallitasok::findOne(1),
        ]);
    }

    public function actionSettingsCountries() {
        return $this->render('settings/countries', [
            'model' => Orszag::findOne(1),
        ]);
    }

    public function actionJob($id) {
        if (!Felhasznalo::current()->isModerator()) {
            return $this->redirect('/admin');
        }
        $model = Job::findOne($id);
        if (!$model) {
            return $this->redirect('/admin');
        }

        return $this->render('pages/job_page', [
            'model' => $model,
        ]);
    }

    public function actionOrder($id) {
        $model = Kosar::findOne($id);
        if (!$model || !$model->megrendelve) {
            return $this->redirect('/admin/orders');
        }
        return $this->render('pages/order_page', [
            'model' => $model,
        ]);
    }

    public function actionOrderItems($id) {
        if (!Felhasznalo::current()->isModerator()) {
            return $this->redirect('/admin');
        }
        $model = Kosar::findOne($id);
        if (!$model || !$model->megrendelve) {
            return $this->redirect('/admin/orders');
        }
        return $this->render('pages/order_page_items', [
            'model' => $model,
        ]);
    }

    public function actionOrderJobs($id) {
        if (!Felhasznalo::current()->isModerator()) {
            return $this->redirect('/admin');
        }
        $model = Kosar::findOne($id);
        if (!$model || !$model->megrendelve) {
            return $this->redirect('/admin/orders');
        }
        return $this->render('pages/order_page_jobs', [
            'model' => $model,
        ]);
    }

    public function actionOrderHistory($id) {
        if (!Felhasznalo::current()->isModerator()) {
            return $this->redirect('/admin');
        }
        $model = Kosar::findOne($id);
        if (!$model || !$model->megrendelve) {
            return $this->redirect('/admin/orders');
        }
        return $this->render('pages/order_page_history', [
            'model' => $model,
        ]);
    }

    public function actionLogin() {
        if (Felhasznalo::current()) {
            return $this->redirect('/admin/index');
        }
        $this->layout = "@app/themes/main/layouts/admin-login";
        return $this->render('index');
    }

    public function action2fa($token, $remember_me) {
        if (Felhasznalo::current()) {
            return $this->redirect('/admin/index');
        }
        $login_2fa = Bejelentkezes2fa::findOne(['token' => $token]);
        if (!$login_2fa) {
            return $this->redirect('/admin');
        }
        $this->layout = "@app/themes/main/layouts/admin-2fa";
        return $this->render('index');
    }

    public function actionError()
    {
        $this->layout = "@app/themes/main/layouts/admin";
        return $this->render('error');
    }

    public function actionTestCancelInvoice() {
        var_dump(Szamlazz::generateCancelInvoice('TST-2023-26'));
    }
}
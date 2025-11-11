<div data-selected-menu="9.5"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'SMS beállítások' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'SMS beállítások',
    'actions' => [

    ]
])?>


<form data-ajax-form data-action="/admin-api/edit?class=Beallitasok&id=1" data-show-popup-on-success>



    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Twilio send URL',
        'name' => 'twilio_send_url',
        'value' => $model->twilio_send_url,
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Twilio SID',
        'name' => 'twilio_sid',
        'value' => $model->twilio_sid,
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Twilio token',
        'name' => 'twilio_token',
        'value' => $model->twilio_token,
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Twilio message service ID',
        'name' => 'twilio_message_service_id',
        'value' => $model->twilio_message_service_id,
    ])?>

    <div class="mt-10 flex justify-end">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>

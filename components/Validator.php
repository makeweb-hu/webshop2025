<?php
namespace app\components;

use app\models\Beallitasok;
use Yii;

class Validator {
    public $rules;
    public $data;
    public $errors;

    function __construct($rules) {
        $this->rules = $rules;
        $values = [];
        foreach ($rules as $key => $_) {
            $values[$key] = Yii::$app->request->post($key) ?? '';
        }
        $this->data = $values;
        $this->errors = [];
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        if ($this->data[$property] ?? null) {
            return $this->data[$property];
        }
    }

    public function validate() {
        $this->errors = [];
        outer:
        foreach ($this->rules as $attr => $rules) {
            $rules = explode('|', $rules);
            foreach ($rules as $rule) {
                $ruleParts = explode(':', $rule);
                $ruleName = trim($ruleParts[0]);
                $ruleParam = trim($ruleParts[1] ?? '');
                $ruleExtraParam = trim($ruleParts[2] ?? '');
                $value = $this->data[$attr];
                switch ($ruleName) {
                    case 'required':
                        if (!trim($value)) {
                            $this->errors[$attr] = 'Kötelező mező!';
                            continue 3;
                        }
                        break;
                    case 'required_array':
                        if (trim($value) === '[]') {
                            $this->errors[$attr] = 'Kötelező mező!';
                            continue 3;
                        }
                        break;
                    case 'max_len':
                        if (mb_strlen($value) > intval($ruleParam)) {
                            $this->errors[$attr] = 'Maximum ' . $ruleParam . ' karakter hosszúnak kell lennie!';
                            continue 3;
                        }
                        break;
                    case 'email':
                        if (!Helpers::is_valid_email($value)) {
                            $this->errors[$attr] = 'Hibás az e-mail cím formátuma!';
                            continue 3;
                        }
                        break;
                    case 'max24hour':
                        if (!( intval($value) >= 0 && intval($value) <= 24 )) {
                            $this->errors[$attr] = 'Maximum 24 munkaóra rögzíthető egy adott napon!';
                            continue 3;
                        }
                        break;
                    case 'must_accept':
                        if (trim($value) !== 'true') {
                            $this->errors[$attr] = 'A továbblépéshez el kell fogadni a feltételeket!';
                            continue 3;
                        }
                        break;
                    case 'checkbox':
                        if ($value != 1 && $value != 0) {
                            $this->errors[$attr] = 'Nem megfelelő adat!';
                            continue 3;
                        }
                        break;
                    case 'same_as':
                        if (trim($value) !== $this->data[trim($ruleParam)]) {
                            $this->errors[$attr] = 'A két mező nem egyezik!';
                            continue 3;
                        }
                        break;
                    case 'same':
                        if (trim($value) !== trim($ruleParam)) {
                            $this->errors[$attr] = 'Nem megfelelő kód!';
                            continue 3;
                        }
                        break;
                    case 'sms_code':
                        if (!preg_match("@^[0-9]{6}$@", $value)) {
                            $this->errors[$attr] = 'Hibás formátum: 6 karakternek kell lennie és csak számokat tartalmazhat!';
                            continue 3;
                        }
                        break;
                    case 'url':
                        if ($value && !preg_match('%^(?:(?:https?)://)?(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $value)) {
                            $this->errors[$attr] = 'Hibás URL!';
                            continue 3;
                        }
                        break;
                    case 'zip_hu':
                        if (!preg_match("@^[0-9]{4}$@", $value)) {
                            $this->errors[$attr] = 'Hibás irányítószám!';
                            continue 3;
                        }
                        break;
                    case 'uint':
                        if ($value && !preg_match("@^[1-9][0-9]*$@", $value)) {
                            $this->errors[$attr] = 'Csak 0-nál nagyobb egész szám adható meg!';
                            continue 3;
                        }
                        break;
                    case 'time':
                        if ($value && !preg_match("@^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$@", $value)) {
                            $this->errors[$attr] = 'Az időpont nem megfelelő!';
                            continue 3;
                        }
                        break;
                    case 'unique':
                        $paramParts = explode('#', $ruleParam);
                        $className = "\\app\\models\\" . trim($paramParts[0]);
                        $fieldName = trim($paramParts[1]);
                        $modelFound = $className::find()->where([($fieldName) => $value])->one();
                        if ($modelFound) {
                            $this->errors[$attr] = 'A megadott érték már foglalt!';
                            continue 3;
                        }
                        break;
                    case 'unique_except':
                        $paramParts = explode('#', $ruleParam);
                        $className = "\\app\\models\\" . trim($paramParts[0]);
                        $fieldName = trim($paramParts[1]);
                        $modelFound = $className::find()->where(['and', ['=', $fieldName, $value], ['<>', 'id', $ruleExtraParam]])->one();
                        if ($modelFound) {
                            $this->errors[$attr] = 'A megadott érték már foglalt!';
                            continue 3;
                        }
                        break;
                    case 'bank_account_hu':
                        if (!preg_match("@^[0-9]{8}-?[0-9]{8}(-?[0-9]{8})?$@", $value)) {
                            $this->errors[$attr] = 'Hibás bankszámlaszám!';
                            continue 3;
                        }
                        break;
                    case 'tax_number_hu':
                        if (!preg_match("@^[0-9]{8}-[0-9]-[0-9]{2}$@", $value)) {
                            $this->errors[$attr] = 'Hibás adószám! A helyes formátum: XXXXXXXX-X-XX';
                            continue 3;
                        }
                        break;
                    case 'tax_number_hu_person':
                        if (!preg_match("@^[0-9]{10}$@", $value)) {
                            $this->errors[$attr] = 'Hibás adóazonosító jel!';
                            continue 3;
                        }
                        break;
                    case 'student_card':
                        if (!preg_match("@^[0-9]{10}$@", $value)) {
                            $this->errors[$attr] = 'Hibás kártyaszám!';
                            continue 3;
                        }
                        break;
                    case 'taj_number':
                        if (!preg_match("@^[0-9]{9}$@", $value)) {
                            $this->errors[$attr] = 'Hibás TAJ szám!';
                            continue 3;
                        }
                        break;
                    case 'year':
                        if ($value && !preg_match("@^(19|20)[0-9]{2}$@", $value)) {
                            $this->errors[$attr] = 'Hibás évszám!';
                            continue 3;
                        }
                        break;
                    case 'not_feature_year':
                        if ($value && intval($value) > (intval(date('Y')) - 1)) {
                            $this->errors[$attr] = 'Hibás évszám!';
                            continue 3;
                        }
                        break;
                    case 'day':
                        if (!preg_match("@^([1-9]|1[0-9]|2[0-9]|30|31)$@", $value)) {
                            $this->errors[$attr] = 'Hibás nap!';
                            continue 3;
                        }
                        break;
                    case 'exists':
                        $paramParts = explode('#', $ruleParam);
                        $className = "\\app\\models\\" . trim($paramParts[0]);
                        $fieldName = trim($paramParts[1]);
                        // Remove array (json) brackets
                        $value = str_replace('[', '', $value);
                        $value = str_replace(']', '', $value);;
                        $modelFound = $className::find()->where([($fieldName) => $value])->one();
                        if (!$modelFound) {
                            $this->errors[$attr] = 'Nem található!';
                            continue 3;
                        }
                        break;
                }
            }
        }
        return count($this->errors) == 0;
    }

    public function getData() {
        return $this->data;
    }

    public function getErrors() {
        return ['error' => $this->errors];
    }

    public function loadData($model, $attrs = '') {
        if (!$attrs) {
            // Load all
            foreach ($this->data as $attr => $value) {
                //if (property_exists($model, $attr)) {
                try {
                    $model->$attr = $value;
                } catch (\Throwable $e) {

                }
                //}
            }
            return;
        }
        $attrs = explode(',', $attrs);
        foreach ($attrs as $attr) {
            $model->$attr = $this->data[$attr] ?? null;
        }
    }

    public function loadDataExcept($model, $attrs = '') {
        $attrs = explode(',', $attrs);
        // Load all
        foreach ($this->data as $attr => $value) {
            //if (property_exists($model, $attr)) {
            try {
                if (!in_array($attr, $attrs)) {
                    $model->$attr = $value;
                }
            } catch (\Throwable $e) {

            }
            //}
        }
    }
}
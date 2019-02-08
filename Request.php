<?php
class Request
{
    protected $errors = [];
    public $cleanPostParams = [];
    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === "GET";
    }
    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === "POST";
    }

    /**
     * Проверка на пустую строку
     *
     * @param $name
     * @return $this
     */
    public function required($name)
    {
        if(empty($this->getFromPostWithClean($name))) {
            $this->errors[$name][] = 'Поле обязательно для заполнения';
        }
        return $this;
    }

    /**
     * Максимальное кол-во символов
     *
     * @param $name
     * @param $max
     * @return $this
     */
    public function maxSymbols($name, $max)
    {
        if(mb_strlen($this->getFromPostWithClean($name)) > $max) {
            $this->errors[$name][] = 'Максимальное кол-во символов ' . $max;
        }
        return $this;
    }

    /**
     * Минимальное кол-во символов
     *
     * @param $name
     * @param $min
     * @return $this
     */
    public function minSymbols($name, $min)
    {
        if(mb_strlen($this->getFromPostWithClean($name)) < $min) {
            $this->errors[$name][] = 'Минимальное кол-во символов ' . $min;
        }
        return $this;
    }

    /**
     * Проверка email на корректность
     *
     * @param $name
     * @return $this
     */
    public function correctEmail($name)
    {
        if (!filter_var($this->getFromPostWithClean($name), FILTER_VALIDATE_EMAIL)) {
            $this->errors[$name][] = 'Некорректный e-mail адрес';
        }

        return $this;
    }

    /**
     * Только число
     *
     * @param $name
     * @return $this
     */
    public function isNumber($name)
    {
        if (!is_numeric($this->getFromPostWithClean($name)) && !empty($this->getFromPostWithClean($name))) {
            $this->errors[$name][] = "Строка должна содержать число";
        }

        return $this;
    }

    /**
     * Только массив
     *
     * @param $name
     * @return $this
     */
    public function isArray($name)
    {
        if (!is_array($this->getFromPostWithClean($name))) {
            $this->errors[$name][] = "Array!";
        }

        return $this;
    }

    /**
     * Только строка
     *
     * @param $name
     * @return $this
     */
    public function isString($name)
    {
        if (!is_string($this->getFromPostWithClean($name))) {
            $this->errors[$name][] = "Значение должно содержать строку";
        }

        return $this;
    }
    /**
     * Значение не должно быть отрицательным
     *
     * @param $name
     * @return $this
     */
    public function isNotNegativeNumber($name)
    {
        if ($this->getFromPostWithClean($name) < 0) {
            $this->errors[$name][] = "Число не может быть отрицательным";
        }

        return $this;
    }

    /**
     * Максимальное числовое значение
     *
     * @param $name
     * @param $maxValue
     * @return $this
     */
    public function maxValueNumber($name, $maxValue)
    {
        if ($this->getFromPostWithClean($name) > $maxValue) {
            $this->errors[$name][] = "Значение не может превышать " . $maxValue;
        }

        return $this;
    }

    /**
     * Минимальное числовое значение
     *
     * @param $name
     * @param $minValue
     * @return $this
     */
    public function minValueNumber($name, $minValue)
    {
        if ($this->getFromPostWithClean($name) > $minValue) {
            $this->errors[$name][] = "Значение не может быть меньше " . $minValue;
        }

        return $this;
    }

    /**
     * Корректность даты
     *
     * @param $name
     * @return $this
     */
    public function correctPublishDate($name) {
        if (date('U', strtotime($this->getFromPostWithClean($name))) < mktime(0, 0, 0)
            && !empty($this->getFromPostWithClean($name))) {

            $this->errors[$name][] = "Дата публикации не может быть раньше текущей даты";
        }

        return $this;
    }

    /**
     * Не пустое значние радиокнопки
     *
     * @param $name
     * @return $this
     */
    public function radiobuttonIsNotEmpty($name) {
        if (!$this->getFromPostWithClean($name)) {
            $this->errors[$name][] = "Выберите один из вариантов";
        }

        return $this;
    }

    /**
     * Не пустое значение селекта
     *
     * @param $name
     * @param $val1
     * @param $val2
     * @param $val3
     * @return $this
     */
    public function selectIsNotEmptyValues($name)
    {
        if (!$this->getFromPostWithClean($name)) {
            $this->errors[$name][] = "Выберите категорию";
        }

        return $this;
    }

    /**
     * Значение совпадает с одним из заданных
     *
     * @param $name
     * @param $val1
     * @param $val2
     * @param $val3
     * @return $this
     */
    public function inValues($name, $val1, $val2, $val3)
    {
        if ($this->getFromPostWithClean($name) != $val1 && $this->getFromPostWithClean($name) != $val2 &&
            $this->getFromPostWithClean($name) != $val3){
            $this->errors[$name][] = "Значение должно равняться " . $val1 . ', ' . $val2 . ', ' . $val3;
        }

        return $this;
    }

    /**
     * Значение НЕ совпадает ни с одним из заданных
     *
     * @param $name
     * @param $val1
     * @param $val2
     * @param $val3
     * @return $this
     */
    public function inNotValues($name, $val1, $val2, $val3)
    {
        if ($this->getFromPostWithClean($name) === $val1 && $this->getFromPostWithClean($name) === $val2 &&
            $this->getFromPostWithClean($name) === $val3){
            $this->errors[$name][] = "Значение не должно равняться " . $val1 . ', ' . $val2 . ', ' . $val3;
        }

        return $this;
    }

    /**
     * Значение в указанном промежутке
     *
     * @param $name
     * @param $val1
     * @param $val2
     * @return $this
     */
    public function isBetween($name, $val1, $val2)
    {
        if ($this->getFromPostWithClean($name) < $val1 && $this->getFromPostWithClean($name) > $val2){
            $this->errors[$name][] = 'Значение должно быть в диапазаоне между ' . $val1 . ' и ' . $val2;
        }

        return $this;
    }

    public function isValid(): bool
    {
        return !count($this->errors);
    }
    public function getErrors(): array
    {
        return $this->errors;
    }
    /*
     * Получение и очистка из поста.
     */
    public function getFromPostWithClean($name)
    {
        if(isset($this->cleanPostParams[$name]) && $this->cleanPostParams[$name]) {
            return $this->cleanPostParams[$name];
        }else {
            $value = $_POST[$name];
            $value = trim($value);
            $value = htmlspecialchars($value);
            $this->cleanPostParams[$name] = $value;
            return $value;
        }
    }
}
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute ต้องได้รับการยอมรับ',
    'active_url' => ':attribute ไม่ใช่ URL ที่ถูกต้อง',
    'after' => ':attribute ต้องเป็นวันที่หลัง :date',
    'after_or_equal' => ':attribute ต้องเป็นวันที่หลังหรือเท่ากับ :date',
    'alpha' => ':attribute ต้องเป็นตัวอักษรเท่านั้น',
    'alpha_dash' => ':attribute ต้องมีเฉพาะตัวอักษร ตัวเลข ขีดกลาง และขีดล่างเท่านั้น',
    'alpha_num' => ':attribute ต้องมีเฉพาะตัวอักษรและตัวเลขเท่านั้น',
    'array' => ':attribute จะต้องเป็นอาร์เรย์',
    'before' => ':attribute ต้องเป็นวันที่ก่อน :date',
    'before_or_equal' => ':attribute ต้องเป็นวันที่ก่อนหรือเท่ากับ :date',
    'between' => [
        'numeric' => ':attribute ต้องอยู่ระหว่าง :min ถึง :max',
        'file' => ':attribute ต้องอยู่ระหว่าง :min ถึง :max กิโลไบต์ (KB)',
        'string' => ':attribute ต้องอยู่ระหว่างอักขระ :min ถึง :max',
        'array' => ':attribute ต้องอยู่ระหว่าง :min ถึง :max รายการ',
    ],
    'boolean' => ':attribute ต้องเป็นจริงหรือเท็จเท่านั้น',
    'confirmed' => 'การยืนยัน :attribute ไม่ตรงกัน',
    'date' => ':attribute ไม่ใช่วันที่ที่ถูกต้อง',
    'date_equals' => ':attribute ต้องเป็นวันที่เท่ากับ :date',
    'date_format' => ':attribute ไม่ตรงกับรูปแบบ :format',
    'different' => ':attribute และ :other ต้องไม่เหมือนกัน',
    'digits' => ':attribute ต้องเป็นตัวเลข :digits ตัว',
    'digits_between' => ':attribute ต้องอยู่ระหว่าง :min ถึง :max ตัวเลข',
    'dimensions' => ':attribute มีขนาดภาพไม่ถูกต้อง',
    'distinct' => ':attribute มีค่าซ้ํากัน',
    'email' => ':attribute ต้องเป็นที่อยู่อีเมลที่ถูกต้อง',
    'ends_with' => ':attribute ต้องลงท้ายด้วยค่าใดค่าหนึ่งต่อไปนี้: :values',
    'exists' => ':attribute ที่ถูกเลือกไม่ถูกต้อง',
    'file' => ':attribute จะต้องเป็นไฟล์',
    'filled' => 'ช่อง :attribute จะต้องมีค่า',
    'gt' => [
        'numeric' => ':attribute ต้องมากกว่า :value',
        'file' => ':attribute ต้องมากกว่า :value กิโลไบต์ (KB)',
        'string' => ':attribute ต้องมากกว่า :value อักขระ',
        'array' => ':attribute ต้องมีมากกว่า :value รายการ',
    ],
    'gte' => [
        'numeric' => ':attribute ต้องมากกว่าหรือเท่ากับ :value',
        'file' => ':attribute ต้องมากกว่าหรือเท่ากับ :value กิโลไบต์ (KB)',
        'string' => ':attribute ต้องมากกว่าหรือเท่ากับ :value อักขระ',
        'array' => ':attribute ต้องมีมากกว่าหรือเท่ากับ :value รายการ',
    ],
    'image' => ':attribute ต้องเป็นรูปภาพ',
    'in' => ':attribute ที่ถูกเลือกไม่ถูกต้อง',
    'in_array' => ':attribute ไม่มีใน :other',
    'integer' => ':attribute ต้องเป็นจํานวนเต็ม',
    'ip' => ':attribute ต้องเป็นที่อยู่ IP ที่ถูกต้อง',
    'ipv4' => ':attribute ต้องเป็นที่อยู่ IPv4 ที่ถูกต้อง',
    'ipv6' => ':attribute ต้องเป็นที่อยู่ IPv6 ที่ถูกต้อง',
    'json' => ':attribute ต้องเป็นสตริง JSON ที่ถูกต้อง',
    'lt' => [
        'numeric' => ':attribute ต้องน้อยกว่า :value',
        'file' => ':attribute ต้องน้อยกว่า :value กิโลไบต์ (KB)',
        'string' => ':attribute ต้องน้อยกว่า :value อักขระ',
        'array' => ':attribute ต้องมีน้อยกว่า :value รายการ',
    ],
    'lte' => [
        'numeric' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value',
        'file' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value กิโลไบต์ (KB)',
        'string' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value อักขระ',
        'array' => ':attribute ต้องมีน้อยกว่าหรือเท่ากับ :value รายการ',
    ],
    'max' => [
        'numeric' => ':attribute ต้องไม่มากกว่า :max',
        'file' => ':attribute ต้องไม่เกิน :max กิโลไบต์ (KB)',
        'string' => ':attribute ต้องไม่เกิน :max อักขระ',
        'array' => ':attribute ต้องไม่มีมากกว่า :max รายการ',
    ],
    'mimes' => ':attribute ต้องเป็นไฟล์ประเภท: :values',
    'mimetypes' => ':attribute ต้องเป็นไฟล์ประเภท: :values',
    'min' => [
        'numeric' => ':attribute ต้องมีอย่างน้อย :min',
        'file' => ':attribute ต้องมีอย่างน้อย :min กิโลไบต์ (KB)',
        'string' => ':attribute ต้องมีอย่างน้อย :min อักขระ',
        'array' => ':attribute ต้องมีอย่างน้อย :min รายการ',
    ],
    'multiple_of' => ':attribute จะต้องเป็นผลคูณของ :value',
    'not_in' => ':attribute ที่ถูกเลือกไม่ถูกต้อง',
    'not_regex' => ':attribute รูปแบบไม่ถูกต้อง',
    'numeric' => ':attribute ต้องเป็นตัวเลข',
    'password' => 'รหัสผ่านไม่ถูกต้อง',
    'present' => 'ต้องมีฟิลด์ :attribute',
    'regex' => 'รูปแบบ :attribute ไม่ถูกต้อง',
    'required' => 'ช่อง :attribute จะต้องมีค่า',
    'required_if' => ':attribute จำเป็นเมื่อ :other คือ :value',
    'required_unless' => ':attribute จำเป็น เว้นแต่ :other จะอยู่ใน :values',
    'required_with' => ':attribute จำเป็นเมื่อ :values ​​ปรากฏ',
    'required_with_all' => ':attribute จำเป็นเมื่อ :values ​​ปรากฏ',
    'required_without' => ':attribute จำเป็นเมื่อ :values ​​ไม่ปรากฏ',
    'required_without_all' => ':attribute จำเป็นเมื่อไม่มี :values ​​ปรากฏ',
    'prohibited' => ':attribute เป็นสิ่งต้องห้าม',
    'prohibited_if' => 'ห้ามใช้ฟิลด์ :attribute เมื่อ :other คือ :value',
    'prohibited_unless' => 'ห้ามใช้ช่อง :attribute เว้นแต่ :other จะอยู่ใน :values',
    'same' => ':attribute และ :other ต้องตรงกัน',
    'size' => [
        'numeric' => ':attribute ต้องมีขนาด :size',
        'file' => ':attribute ต้องมีขนาด :size กิโลไบต์ (KB)',
        'string' => ':attribute ต้องมีขนาด :size อักขระ',
        'array' => ':attribute ต้องบรรจุได้ :size รายการ',
    ],
    'starts_with' => ':attribute ต้องขึ้นต้นด้วยค่าใดค่าหนึ่งต่อไปนี้: :values',
    'string' => ':attribute ต้องเป็นสตริง',
    'timezone' => ':attribute ต้องเป็นโซนที่ถูกต้อง',
    'unique' => ':attribute ถูกนำไปใช้แล้ว',
    'uploaded' => ':attribute ไม่สามารถอัพโหลดได้',
    'url' => ':attribute รูปแบบไม่ถูกต้อง',
    'uuid' => ':attribute ต้องเป็น UUID ที่ถูกต้อง',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
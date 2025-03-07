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

    'accepted' => ':attribute 必須被接受。',
    'active_url' => ':attribute 不是一個有效的 URL。',
    'after' => ':attribute 必須是 :date 之後的日期。',
    'after_or_equal' => ':attribute 必須是 :date 或更晚的日期。',
    'alpha' => ':attribute 只能包含字母。',
    'alpha_dash' => ':attribute 只能包含字母、數字、破折號和底線。',
    'alpha_num' => ':attribute 只能包含字母和數字。',
    'array' => ':attribute 必須是一個陣列。',
    'before' => ':attribute 必須是 :date 之前的日期。',
    'before_or_equal' => ':attribute 必須是 :date 或更早的日期。',
    'between' => [
        'numeric' => ':attribute 必須介於 :min 和 :max 之間。',
        'file' => ':attribute 必須介於 :min 和 :max KB 之間。',
        'string' => ':attribute 必須介於 :min 和 :max 個字元之間。',
        'array' => ':attribute 必須包含 :min 到 :max 個項目。',
    ],
    'boolean' => ':attribute 欄位必須為 true 或 false。',
    'confirmed' => ':attribute 確認欄位不匹配。',
    'date' => ':attribute 不是一個有效的日期。',
    'date_equals' => ':attribute 必須是 :date 的日期。',
    'date_format' => ':attribute 不符合格式 :format 。',
    'different' => ':attribute 和 :other 必須不同。',
    'digits' => ':attribute 必須是 :digits 數字。',
    'digits_between' => ':attribute 必須介於 :min 和 :max 數字之間。',
    'dimensions' => ':attribute 的圖像尺寸無效。',
    'distinct' => ':attribute 欄位具有重複的值。',
    'email' => ':attribute 必須是一個有效的電子郵件地址。',
    'ends_with' => ':attribute 必須以 :values 結尾。',
    'exists' => '所選的 :attribute 無效',
    'file' => ':attribute 必須是一個檔案。',
    'filled' => ':attribute 欄位必須有值。',
    'gt' => [
        'numeric' => ':attribute 必須大於 :value 。',
        'file' => ':attribute 必須大於 :value 千位元組。',
        'string' => ':attribute 必須大於 :value 個字元。',
        'array' => ':attribute 必須有 :value 項目或更多。',
    ],
    'gte' => [
        'numeric' => ':attribute 必須大於或等於:value 。',
        'file' => ':attribute 必須大於或等於 :value 千位元組。',
        'string' => ':attribute 必須大於或等於 :value 個字元。',
        'array' => ':attribute 必須有 :value 項目或更多。',
    ],
    'image' => ':attribute 必須是圖像。',
    'in' => '所選的 :attribute 無效',
    'in_array' => ':attribute 欄位不存在於 :other 。',
    'integer' => ':attribute 必須是整數。',
    'ip' => ':attribute 必須是一個有效的 IP 地址。',
    'ipv4' => ':attribute 必須是有效的 IPv4 位址。',
    'ipv6' => ':attribute 必須是有效的 IPv6 位址。',
    'json' => ':attribute 必須是有效的 JSON 字串。',
    'lt' => [
        'numeric' => ':attribute 必須小於 :value 。',
        'file' => ':attribute 必須小於 :value 千位元組。',
        'string' => ':attribute 必須小於 :value 個字元。',
        'array' => ':attribute 必須有 :value 項目或更少。',
    ],
    'lte' => [
        'numeric' => ':attribute 必須小於或等於:value。',
        'file' => ':attribute 必須小於或等於 :value 千位元組。',
        'string' => ':attribute 必須小於或等於 :value 個字元。',
        'array' => ':attribute 必須有 :value 項目或更少。',
    ],
    'max' => [
        'numeric' => ':attribute 不得大於:max 。',
        'file' => ':attribute 不得大於:max KB。',
        'string' => ':attribute 不得大於:max 個字元。',
        'array' => ':attribute 的項數不得超過 :max 。',
    ],
    'mimes' => ':attribute 必須是類型為: :values 的檔案。',
    'mimetypes' => ':attribute 必須是類型為: :values 的檔案。',
    'min' => [
        'numeric' => ':attribute 必須至少為 :min 。',
        'file' => ':attribute 必須至少為 :min 千位元組。',
        'string' => ':attribute 必須至少為 :min 個字元。',
        'array' => ':attribute 必須至少包含 :min 項目。',
    ],
    'multiple_of' => ':attribute 必須是 :value 的倍數。',
    'not_in' => '所選的 :attribute 無效',
    'not_regex' => ':attribute 格式無效。',
    'numeric' => ':attribute 必須是數字。',
    'password' => '密碼不正確',
    'present' => ':attribute 欄位必須有值。',
    'regex' => ':attribute 格式無效。',
    'required' => ':attribute 欄位必須有值。',
    'required_if' => ':attribute 欄位在 :other 為 :value 時必須有值。',
    'required_unless' => ':attribute 欄位是必要的，除非 :other 位於 :values 中。',
    'required_with' => '當 :values 存在時，:attribute 欄位是必需的。',
    'required_with_all' => '當 :values 存在時，:attribute 欄位是必需的。',
    'required_without' => '當 :values 不存在時，:attribute 欄位是必需的。',
    'required_without_all' => '當 :values 都不存在時，:attribute 欄位是必需的。',
    'prohibited' => ':attribute 欄位是禁止的。',
    'prohibited_if' => ':attribute 欄位在 :other 為 :value 時是禁止的。',
    'prohibited_unless' => ':attribute 欄位除非 :other 位於 :values 中是禁止的。',
    'same' => ':attribute 和 :other 必須匹配。',
    'size' => [
        'numeric' => ':屬性必須是 :size 。',
        'file' => ':attribute 必須是 :size 千字節。',
        'string' => ':attribute 必須是 :size 字元。',
        'array' => ':attribute 必須包含 :size 項目。',
    ],
    'starts_with' => ':attribute 必須以 :values 開始。',
    'string' => ':attribute 必須是字串。',
    'timezone' => ':attribute 必須是有效的時區。',
    'unique' => ':attribute 已經存在。',
    'uploaded' => ':attribute 上傳失敗。',
    'url' => ':attribute 格式無效。',
    'uuid' => ':attribute 必須是有效的 UUID。',

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

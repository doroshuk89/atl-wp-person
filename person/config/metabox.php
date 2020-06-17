<?php
return array(
    // метабокс для адреса
    array(
        'id'	=>	'Address',
        'name'	=>	'Адрес',
        'post'	=>	array('teamperson'), // не только для постов, но и для страниц
        'pos'	=>	'normal',
        'pri'	=>	'high',
        'cap'	=>	'edit_posts',
        'args'	=>	array(
            array(
                'id'			=>	'address',
                'title'			=>	'Адрес',
                'placeholder'   =>  'Адрес',
                'desc'			=>	'Адрес участника команды',
                'type'			=>	'text',
                'cap'			=>	'edit_posts'
            )
        )
    ),

    // метабокс для телефона
    array(
        'id'	=>	'Phone',
        'name'	=>	'Номер телефон',
        'post'	=>	array('teamperson'), // не только для постов, но и для страниц
        'pos'	=>	'normal',
        'pri'	=>	'high',
        'cap'	=>	'edit_posts',
        'args'	=>	array(
            array(
                'id'			=>	'phone',
                'title'			=>	'Телефон',
                'placeholder'   =>  'Номер телефона',
                'desc'			=>	'Номер телефона участника команды',
                'type'			=>	'text',
                'cap'			=>	'edit_posts'
            )
        )
    ),

    // метабокс для email
    array(
        'id'	=>	'Email',
        'name'	=>	'Email-адрес',
        'post'	=>	array('teamperson'), // не только для постов, но и для страниц
        'pos'	=>	'normal',
        'pri'	=>	'high',
        'cap'	=>	'edit_posts',
        'args'	=>	array(
            array(
                'id'			=>	'email',
                'title'			=>	'Email',
                'placeholder'   =>  'E-mail адрес',
                'desc'			=>	'Email адрес участника команды',
                'type'			=>	'text',
                'cap'			=>	'edit_posts'
            )
        )
    ),

    // метабокс для sort (сортировки)
    array(
        'id'	=>	'Order',
        'name'	=>	'Сортировка',
        'post'	=>	array('teamperson'), // не только для постов, но и для страниц
        'pos'	=>	'side',
        'pri'	=>	'default',
        'cap'	=>	'edit_posts',
        'args'	=>	array(
            array(
                'id'			=>	'order',
                'title'			=>	'Order',
                'placeholder'   =>  'Priority',
                'desc'			=>	'Сортировка',
                'type'			=>	'number',
                'std'           =>  1,
                'cap'			=>	'edit_posts'
            )
        )
    ),
);
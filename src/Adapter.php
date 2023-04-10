<?php

namespace Fayrest\Journalworker;

class Adapter
{
    const NEWS_LINK = 'https://alidi.ru/press-center/blog/';

    public static function adaptee($data)
    {
        $adaptee['end_time'] = time() + 86400;
        $adaptee['data'] = (new self)->changeData(is_string($data) ? json_decode($data, true) : $data);

        return $adaptee;
    }

    public  function changeData($data)
    {
        $new = [];

        foreach ($data as $key => $item) {
            $new[$key]['link'] = self::NEWS_LINK . $item['id'];
            $new[$key]['title'] = $item['title'];
            $new[$key]['image'] = isset($item['files'][0]['path']) && isset($item['files'][0]['name']) ?
                "https://prof.alidi.ru/{$item['files'][0]['path']}{$item['files'][0]['name']}"
                : null;
            $new[$key]['view_count'] = $item['viewCount'];
            $new[$key]['like_count'] = $item['likeCount'];
            $new[$key]['published_date'] = $item['publishedDate'];
        }

        return $new;
    }
}

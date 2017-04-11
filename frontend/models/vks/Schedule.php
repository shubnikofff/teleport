<?php
/**
 * oskr-portal
 * Created: 18.10.16 13:39
 * @copyright Copyright (c) 2016 OSKR NIAEP
 */

namespace frontend\models\vks;

use yii\helpers\ArrayHelper;
use yii\mongodb\Collection;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\Javascript;

/**
 * @author Shubnikov Alexey <a.shubnikov@niaep.ru>
 *
 * Schedule
 */
class Schedule
{
    /**
     * @param UTCDateTime $date
     * @return array|string
     */
    public static function participantsCountPerHour(UTCDateTime $date)
    {
        /** @var $collection Collection */
        $collection = \Yii::$app->get('mongodb')->getCollection(Request::collectionName());

        $map = new Javascript("function() {
            for (var i = 7 * 60; i < 22 * 60; i = i + 30) {
                if (this.beginTime < i + 30 && this.endTime > i) {
                    emit(i, this.participantsId.length);
                }
            }
        }");

        $reduce = new Javascript("function (key, values) {return Array.sum(values)}");

        $out = ['inline' => true];

        $condition = [
            'date' => $date,
            'mode' => Request::MODE_WITH_VKS,
            'status' => ['$ne' => Request::STATUS_CANCELED]
        ];

        $result = $collection->mapReduce($map, $reduce, $out, $condition);

        return ArrayHelper::map($result, '_id', 'value');

    }
}
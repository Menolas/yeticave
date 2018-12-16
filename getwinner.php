<?php

// Получаем массив лотов у которых не определен победитель торгов
$no_winners_lots = [];
$no_winners_lots = get_no_winners_lots($link);

$winners = [];

if (get_no_winners_lots($link)) {
    foreach ($no_winners_lots as $lot) {
        var_dump($lot[id]);
        die();
        $lot_id = $lot[id];
        $bids = [];
        $bids = get_bids_for_lot($link, $lot_id);

        if ($bids) {
            $winner = [];
            $max_bid = MAX($bids[amount]);

            foreach ($bids as $bid) {

                if ($bid[amount] === $max_bid) {

                    $winner[user_id] = $bid[user_id];
                    $winner[user_name] = $bid[name];
                    $winner[user_email] = $bid[email];
                    array_push($winners, $winner);
                }
            }
        }
        return $winners;
    }
}

var_dump($winners);
die();

<?php

$names = array(
        'James', 'John', 'Bob', 'Mike', 'Bill', 'Dave', 'Rich', 'Charlie', 'Josh', 'Tom',
        'Chris', 'Dan', 'Paul', 'Mark', 'Don', 'George', 'Ken', 'Steve', 'Ed', 'Brian',
        'Ron', 'Anthony', 'Kevin', 'Jason', 'Jeff', 'Mary', 'Pat', 'Linda', 'Barbara', 'Eliza',
        'Jennie', 'Paulina', 'Suzie', 'Margareth', 'Dorothy', 'Lisa', 'Nancy', 'Karen', 'Bettie', 'Helen',
        'Sandrine', 'Donna', 'Carol', 'Ruth', 'Sharon', 'Michelle', 'Laura', 'Sarah', 'Kim', 'Jessica');

$surnames = array(
        'Washington', 'Adams', 'Jefferson', 'Madison', 'Monroe', 'Quincy', 'Jackson', 'van Buren', 'Harrison', 'Tyler',
        'Polk', 'Taylor', 'Fillmore', 'Pierce', 'Buchanan', 'Lincoln', 'Johnson', 'Grant', 'Hayes', 'Garfield', 'Arthur',
        'Cleveland', 'McKinley', 'Roosevelt', 'Taft', 'Wilson', 'Harding', 'Coolidge', 'Hoover', 'Truman', 'Eisenhower',
        'Kennedy', 'Nixon', 'Ford', 'Carter', 'Reagan', 'Bush', 'Clinton', 'Perez', 'Sanchez', 'Gomez', 'Zechiel',
        'Muller', 'Schmidt', 'Schneider', 'Fischer', 'Meyer', 'Wagner', 'Becker', 'Huffman', 'Richter', 'Klein');

$jobs = array('Teacher', 'Student', 'Programmer', 'Tycoon', 'Director', 'Manager', 'Scientist', 'Unemployed');

$phrases = array(
    'May I borrow your car tomorrow?',
    'Congrats on Wedding!',
    'Have you been in office today?',
    'Hey, Dude! Write something on my wall!',
    'These news fron NNC are damn boring...',
    'My ,,,^.,.^,,, it is for you @>---',
    'Going to Cinematic Theatre on weekend - will you join?',
    'Sorry could not answer, had a day at the races and night in the opera',
    'Can you fetch me from library this night please?',
    'Never know you have a daughter :)',
    'For whom did you vote on elections, by the way?',
    'There are few pies and cakes due to my birthday :) Come and join!',
    'It is raining for a week already, gonna hate this place!',
    'Why have not you told you are changing the job? We had a nice position...',
    'Have you solved last problem at ProjectEuler?',
    'Can you break the Caesar Cipher at CodeAbbey?');

$net = array();

function generatePerson() {
    global $names, $surnames, $jobs, $phrases;
    $p = new stdClass();
    $name = $names[rand(0, count($names) - 1)];
    $surname = $surnames[rand(0, count($surnames) - 1)];
    $initial = chr(ord('A') + rand(0, 25));
    $p->name = "$name $initial $surname";
    $p->url = strtolower(str_replace(' ', '-', $p->name));
    $p->wealth = rand(2, 19) * pow(10, rand(2, 8));
    $p->occupation = $jobs[array_rand($jobs)];
    $p->friends = array();
    $p->birthday = rand(1, 12) . '/' . rand(1, 28) . '/' . rand(1950, 1999);
    $p->wall = array();
    return $p;
}

function generatePeople($n) {
    global $net, $phrases;
    for ($i = 0; $i < $n; $i++) {
        $p = generatePerson();
        $net[$p->url] = $p;
    }
    $net['index'] = generatePerson();
    $net['index']->name = 'John X Doe';
    $net['index']->url = 'index';
    $urls = array_keys($net);
    foreach ($net as $url => $person) {
        $j = rand(2, 5);
        $fs = array();
        while (count($fs) < $j) {
            $fs[$urls[rand(0, count($urls) - 1)]] = 1;
        }
        $person->friends = array_keys($fs);
        shuffle($phrases);
        $j = rand(2, 4);
        while ($j-- > 0) {
            $person->wall[$urls[rand(0, count($urls) - 1)]] = $phrases[$j];
        }
    }
}

function generatePage($url) {
    global $net, $data;
    $data = clone $net[$url];
    $fs = $data->friends;
    $data->friends = array();
    foreach ($fs as $f) {
        $ff = new stdClass();
        $ff->name = $net[$f]->name;
        $ff->url = $net[$f]->url;
        $data->friends[] = $ff;
    }
    $notes = array();
    foreach ($data->wall as $url => $text) {
        $note = new stdClass();
        $note->text = $text;
        $note->name = $net[$url]->name;
        $note->url = $url;
        $notes[] = $note;
    }
    $data->wall = $notes;
    ob_start();
    include './template.php';
    $page = ob_get_contents();
    ob_end_clean();
    return $page;
}

generatePeople(1200);


foreach ($net as $p) {
    file_put_contents("{$p->url}.html", generatePage($p->url));
}

//file_put_contents("index.html", generatePage('index'));

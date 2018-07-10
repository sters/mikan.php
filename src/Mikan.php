<?php
namespace Mikan;

class Mikan
{
    public function split($str)
    {
        $pregSplitOption = PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY;
        $words = preg_split($this->getRegexpKeywords(), $str, 0, $pregSplitOption);

        $words = array_reduce($words, function ($prev, $word) use ($pregSplitOption) {
            $splitted = preg_split($this->getRegexpJoshi(), $word, 0, $pregSplitOption);
            return array_merge(is_null($prev) ? [] : $prev, $splitted);
        });
        $words = array_reduce($words, function ($prev, $word) use ($pregSplitOption) {
            $splitted = preg_split($this->getRegexpBracketsBegin(), $word, 0, $pregSplitOption);
            return array_merge(is_null($prev) ? [] : $prev, $splitted);
        });
        $words = array_reduce($words, function ($prev, $word) use ($pregSplitOption) {
            $splitted = preg_split($this->getRegexpBracketsEnd(), $word, 0, $pregSplitOption);
            return array_merge(is_null($prev) ? [] : $prev, $splitted);
        });
        $words = array_filter($words);

        $result = [];
        $prevType = '';
        $prevWord = '';
        foreach ($words as $word) {
            $token = preg_match($this->getRegexpPeriods(), $word) || preg_match($this->getRegexpJoshi(), $word);

            if (preg_match($this->getRegexpBracketsBegin(), $word)) {
                $prevType = 'bracketBegin';
                $prevWord = $word;
                continue;
            }

            if (preg_match($this->getRegexpBracketsEnd(), $word)) {
                $result[count($result) - 1] .= $word;
                $prevType = 'bracketEnd';
                $prevWord = $word;
                continue;
            }

            if ($prevType === 'bracketBegin') {
                $word = $prevWord . $word;
                $prevWord = '';
                $prevType = '';
            }

            // すでに文字が入っている上で助詞が続く場合は結合する
            if (count($result) > 0 && $token && $prevType === '') {
                $result[count($result) - 1] .= $word;
                $prevType = 'keyword';
                $prevWord = $word;
                continue;
            }

            // 単語のあとの文字がひらがななら結合する
            $isHiragana = preg_match($this->getRegexpHiragana(), $word);
            if (count($result) > 1 && $token || ($prevType === 'keyword' && $isHiragana)) {
                $result[count($result) - 1] .= $word;
                $prevType = '';
                $prevWord = $word;
                continue;
            }

            $result[] = $word;
            $prevType = 'keyword';
            $prevWord = $word;
        }

        return $result;
    }

    private function getRegexpJoshi()
    {
        return '/(' . implode('|', [
            'でなければ',
            'について',
            'かしら',
            'くらい',
            'けれど',
            'なのか',
            'ばかり',
            'ながら',
            'ことよ',
            'こそ',
            'こと',
            'さえ',
            'しか',
            'した',
            'たり',
            'だけ',
            'だに',
            'だの',
            'つつ',
            'ても',
            'てよ',
            'でも',
            'とも',
            'から',
            'など',
            'なり',
            'ので',
            'のに',
            'ほど',
            'まで',
            'もの',
            'やら',
            'より',
            'って',
            'で',
            'と',
            'な',
            'に',
            'ね',
            'の',
            'も',
            'は',
            'ば',
            'へ',
            'や',
            'わ',
            'を',
            'か',
            'が',
            'さ',
            'し',
            'ぞ',
            'て',
        ]) . ')/u';
    }

    private function getRegexpKeywords()
    {
        return '/(' . implode('|', [
            '\&nbsp;',
            '[a-zA-Z0-9]+\.[a-z]{2,}',
            '[一-龠々〆ヵヶゝ]+',
            '[ぁ-んゝ]+',
            '[ァ-ヴー]+',
            '[#@a-zA-Z0-9]+',
            '[ａ-ｚＡ-Ｚ０-９]+',
        ]) . ')/u';
    }

    private function getRegexpPeriods()
    {
        return '/([\.\,。、！\!？\?]+)$/u';
    }

    private function getRegexpBracketsBegin()
    {
        return '/([〈《「『｢（(\[【〔〚〖〘❮❬❪❨(<{❲❰｛❴])/u';
    }

    private function getRegexpBracketsEnd()
    {
        return '/([〉》」』｣)）\]】〕〗〙〛}>\)❩❫❭❯❱❳❵｝])/u';
    }

    private function getRegexpHiragana()
    {
        return '/^[ぁ-んゝ]+$/u';
    }
}

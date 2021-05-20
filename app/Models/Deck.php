<?php
namespace App\Models;

class Deck
{
    const SIZE = 6;
    const VALUES = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    const SUIT = ['S', 'C', 'H', 'D'];

    public $cards = [];

    // 6*52 Adet kart olan yani 312 adet kart oluşturup desteyi karıştırıyoruz.
    public function createFullDeck()
    {
        if (!$this->cards) {
            $cards = [];
            for($i=0;$i<self::SIZE;$i++) {
                foreach (self::VALUES as $face) {
                    foreach (self::SUIT as $suit) {
                        $cards[] = "{$face}{$suit}";
                    }
                }
            }
            $this->cards = collect($cards)->shuffle();
        }
    }

    // Deste içinden kart seçip çıkmasını sağlıyoruz.
    public function take($n = 1)
    {
        $cards = $this->cards;
        $taken = $cards->splice(0, $n);
        $this->cards = $cards;
        return $taken->all();
    }

    //Eldeki kart değerlerini hesaplama
    public function calcValues($cards){
		$totalValue = 0;
		$aces = 0;

		// $cards = ["2S","10D"]
		foreach($cards as $card){
		    // $card =  "2S" veya "10D" şeklinde geliyor. İlk karakterini alıyoruz.
            $firstText = substr($card,0,1);
            switch ($firstText) {
                case '2':
                    $totalValue += 2; break;
                case '3':
                    $totalValue += 3; break;
                    break;
                case '4':
                    $totalValue += 4; break;
                    break;
                case '5':
                    $totalValue += 5; break;
                    break;
                case '6':
                    $totalValue += 6; break;
                    break;
                case '7':
                    $totalValue += 7; break;
                    break;
                case '8':
                    $totalValue += 8; break;
                    break;
                case '9':
                    $totalValue += 9; break;
                    break;
                case 'J':
                case 'Q':
                case 'K':
                case '10':
                    $totalValue += 10; break;
                    break;
                case 'A':
                    $aces += 1; break;
            }

        }

        //Elinde AS olup olmadığını kontrol etme.
        //Eğer elinde AS varsa ve 21 ' e tamamlamak için 1 yerine 11 olarak kullanılması gerekiyorsa onu hesaba dahil etme
        for($i = 0; $i < $aces; $i++){
            //Eğer toplam değer 10 ' dan büyükse AS 1 olarak hesaplanır.
            if ($totalValue > 10){
                $totalValue += 1;
            }
            else{
                $totalValue += 11;
            }
        }

		//Return
		return $totalValue;

	}

}

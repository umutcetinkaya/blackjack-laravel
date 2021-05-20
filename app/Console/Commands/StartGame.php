<?php

namespace App\Console\Commands;

use App\Models\Deck;
use Illuminate\Console\Command;

class StartGame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:game';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It is a test written for senior php developer quiz.';

    /**
     * Deck
     */
    public $deck = null;

    /**
     * Player Cards
     */
    public $playerCards = [];

    /**
     * Player Card Total
     */
    public $playerCardTotalValue = 0;

    /**
     * Dealer Cards
     */
    public $dealerCards = [];

    /**
     * Dealer Card Total
     */
    public $dealerCardTotalValue = 0;

    /**
     * End Game
     */
    public $endGame = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Game
     */
    public function game()
    {

        $this->line("The cards in your hand:" . implode(",", $this->playerCards));
        $this->line("The total of the cards in your hand:" . $this->playerCardTotalValue);

        if($this->endGame == false) {
            if(count($this->playerCards) == 2) {
                $this->line("The cards in the hands of the dealer:" . $this->dealerCards[0] . " ve [KAPALI]");
            }
        }else{

            $this->line("The cards in the hands of the dealer:" . implode(",", $this->dealerCards));
            $this->line("The total of the cards in the hands of the dealer:" . $this->dealerCardTotalValue);

            if($this->dealerCardTotalValue > 21){
                $this->warn("The total number of cards in the hands of the dealer has exceeded 21. Dealer lost.");
                $this->info("You Win. :)");
            }
            else if($this->playerCardTotalValue > 21){
                $this->error("The total number of cards in your hand has exceeded 21. You lost. :(");
            }
            else if($this->dealerCardTotalValue < 21 && $this->playerCardTotalValue < 21 && $this->dealerCardTotalValue > $this->playerCardTotalValue){
                $this->error("The total of the cards in the hands of the dealer has exceeded the total of the cards in your hand. You lost. :(");
            }
            else if($this->dealerCardTotalValue < 21 && $this->playerCardTotalValue < 21 && $this->dealerCardTotalValue == $this->playerCardTotalValue){
                $this->warn("The dealer and the cards in your hand are equal. Stayed TOGETHER.!");
            }
            else if($this->dealerCardTotalValue < 21 && $this->playerCardTotalValue < 21 && $this->dealerCardTotalValue < $this->playerCardTotalValue){
                $this->info("You Win. :)");
            }
            else if($this->playerCardTotalValue == 21){
                $this->info("BlackJACK! You Win. :)");
            }
            else if($this->dealerCardTotalValue == 21){
                $this->error("Dealer BlackJACK!. You Lost. :(");
            }
        }

    }

    /**
     * Result
     */
    public function result(){

        $this->line("RESULT ............................................................................... ");

        // Oyunu bitir.
        $this->endGame = true;

        // Kurpiyerin eli 17 den küçükse kart al
        if($this->dealerCardTotalValue < 17){
            $oneCard = $this->deck->take(1);
            array_push($this->dealerCards, $oneCard[0]);
            $this->dealerCardTotalValue = $this->deck->calcValues($this->dealerCards);
        }

        // Son oyun çıktılarını göster.
        $this->game();

        $this->line("FINISH GAME ............................................................................... ");

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line("Welcome to our game of blackjack!");

        // Deste oluşturuyoruz
        $this->deck = new Deck();
        $this->deck->createFullDeck();

        // Oyuncu için 2 adet kağıt seçiyoruz
        $this->playerCards = $this->deck->take(2);
        $this->playerCardTotalValue = $this->deck->calcValues($this->playerCards);

        // Kurpiyer için 2 adet kağıt seçiyoruz
        $this->dealerCards = $this->deck->take(2);
        $this->dealerCardTotalValue = $this->deck->calcValues($this->dealerCards);

        // Oyun başlıyor
        $this->line("Start Game ...............................................................................");
        $this->game();

        if ($this->playerCardTotalValue < 21 && $this->confirm('Do you want to card?') == true) {
            $oneCard = $this->deck->take(1);
            array_push($this->playerCards, $oneCard[0]);
            $this->playerCardTotalValue = $this->deck->calcValues($this->playerCards);
            $this->line("Continue ...............................................................................");
            $this->game();
        }

        $this->result();

    }
}

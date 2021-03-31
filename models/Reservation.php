<?php

namespace app\models;

use app\core\Model;
use app\core\Request;

class Reservation extends Model {
    public ?string $isbn = '';
    public ?string $user_id = NULL;
    public ?string $title = '';
    public ?string $name = '';
    public ?string $pickupDate = NULL;

    // To load data from the request
    public function __construct(bool $load = false) {
        if ($load) $this->loadDataFromRequest();
    }

    public static function getAllRervations(Reservation $reservation) {
        $query = 'SELECT bv.isbn, bv.title, r.user_id, u.name, r.`pickupDate` FROM book_view bv 
        JOIN reservation r 
        ON r.isbn = bv.isbn AND bv.isbn LIKE :isbn AND bv.title LIKE :title
        JOIN user u
        ON u.user_id = r.user_id AND u.name LIKE :name';

        // Check if the user_id is set
        if (isset($reservation->user_id) && !empty($reservation->user_id)) {
            $query = $query.' AND u.user_id = :id';
        }

        $statement = self::getDatabase()->prepare($query);
        $statement->bindValue(':isbn', '%'.$reservation->isbn.'%');
        $statement->bindValue(':title', '%'.$reservation->title.'%');
        $statement->bindValue(':name', '%'.$reservation->name.'%');
        
        if (isset($reservation->user_id) && !empty($reservation->user_id)) {
            $statement->bindValue(':name', $reservation->id, \PDO::PARAM_INT);
        }

        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function addReservation(string $user_id, string $isbn, $pickup_date) {
        $statement = self::getDatabase()->prepare("INSERT INTO reservation (user_id, isbn, pickupDate) VALUES (:id, :isbn, :pickup)");
        $statement->bindValue(':id', $user_id);
        $statement->bindValue(':isbn', $isbn);
        $statement->bindValue(':pickup', $pickup_date);
        return $statement->execute();
    }
}
?>
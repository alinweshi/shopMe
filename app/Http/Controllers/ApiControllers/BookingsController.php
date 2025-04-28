<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Booking;
use Illuminate\Cache\Lock;
use App\Models\FlightTicket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Ticket;
use Illuminate\Contracts\Cache\LockTimeoutException;



class BookingsController extends Controller
{
    public function store(FlightTicket $ticket, $quantity, $user_id)
    {
        $lock = Cache::lock('ticket_' . $ticket->id, 30); // 30 seconds lock

        try {
            // Attempt to acquire the lock with a 5-second wait time
            $lock->block(5);

            if ($ticket->stock === 0 || $ticket->stock === null) {
                $lock->release();
                return response()->json(['message' => 'Ticket is not available'], 409);
            }

            if ($ticket->stock < $quantity) {
                $lock->release();
                return response()->json([
                    'message' => 'The requested quantity is not available, only ' . $ticket->stock . ' available'
                ], 409);
            }

            // Update stock
            $ticket->decrement('stock', $quantity);

            // Create booking
            $booking = Booking::create([
                'user_id'   => $user_id,
                'ticket_id' => $ticket->id,
                'quantity'  => $quantity,
            ]);

            // For testing purposes only - remove in production
            sleep(3); // simulate slow processing to test lock

            return response()->json([
                'message' => 'Ticket Booked Successfully',
                'data' => $booking
            ], 200);
        } catch (LockTimeoutException $exception) {
            return response()->json([
                'message' => 'Could not acquire lock for ticket booking. Please try again.',
                'error' => $exception->getMessage()
            ], 423); // 423 Locked status code

        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'An unexpected error occurred while booking the ticket.',
                'error' => $exception->getMessage()
            ], 500);
        } finally {
            // Ensure the lock is always released
            if ($lock->get()) {
                $lock->release();
            }
        }
    }
    // public function store(FlightTicket $ticket, $quantity, $user_id)
    // {
    //     $lock = Cache::lock('ticket_' . $ticket->id, 30); // Increase to 30 seconds
    //     // dd($lock->block(4));
    //     if ($lock->get()) {
    //         // $lock->block(4);
    //         if ($ticket->stock === 0 || $ticket->stock === null) {
    //             return response()->json(['message' => 'Ticket is not available'], 409);
    //         }

    //         if ($ticket->stock < $quantity) {
    //             return response()->json([
    //                 'message' => 'The requested quantity is not available, only ' . $ticket->stock . ' available'
    //             ], 409);
    //         }

    //         // Update stock
    //         $ticket->decrement('stock', $quantity);

    //         // Create booking
    //         $booking = Booking::create([
    //             'user_id'   => $user_id,
    //             'ticket_id' => $ticket->id,
    //             'quantity'  => $quantity,
    //         ]);

    //         sleep(10); // simulate slow processing to test lock

    //         return response()->json([
    //             'message' => 'Ticket Booked Successfully',
    //             'data' => $booking
    //         ], 200);
    //         $lock->release();
    //     }
    //     return response()->json(['message' => 'An error occurred while booking the ticket'], 409);





    //     // try {
    //     //     $lock->block(1);
    //     //     // dd($lock);
    //     //     if ($ticket->stock === 0 || $ticket->stock === null) {
    //     //         return response()->json(['message' => 'Ticket is not available'], 409);
    //     //     }

    //     //     if ($ticket->stock < $quantity) {
    //     //         return response()->json([
    //     //             'message' => 'The requested quantity is not available, only ' . $ticket->stock . ' available'
    //     //         ], 409);
    //     //     }

    //     //     // Update stock
    //     //     $ticket->decrement('stock', $quantity);

    //     //     // Create booking
    //     //     $booking = Booking::create([
    //     //         'user_id'   => $user_id,
    //     //         'ticket_id' => $ticket->id,
    //     //         'quantity'  => $quantity,
    //     //     ]);

    //     //     sleep(10); // simulate slow processing to test lock

    //     //     return response()->json([
    //     //         'message' => 'Ticket Booked Successfully',
    //     //         'data' => $booking
    //     //     ], 200);
    //     // } catch (LockTimeoutException  $exception) {
    //     //     return response()->json([
    //     //         'message' => 'An error occurred while booking the ticket.',
    //     //         'error' => $exception->getMessage()
    //     //     ], 500);
    //     // } finally {
    //     //     $lock->release();
    //     // }
    // }
}

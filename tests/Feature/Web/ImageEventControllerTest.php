<?php
/**
 * Created by PhpStorm.
 * User: alumne
 * Date: 11/05/19
 * Time: 3:55
 */

namespace Tests\Feature\Web;


use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class ImageEventControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /**
     * @test
     */
    public function upload_photo()
    {
        $this->withoutExceptionHandling();
        //see fylesystems.php
        Storage::fake('local');
        $event = factory(Event::class)->create();
        $user=$this->loginAsManager('web');
        //pass array with photo and event id
        $response = $this->post('/image/event',[
            'image' => UploadedFile::fake()->image('photo.jpg'),
            'event_id'=>$event->id
        ]);
        $response->assertRedirect();
        //see fylesystems.php
        Storage::disk('local')->assertExists($photoUrl = 'public/event_images/' . $event->id . '.jpg');
        $eventFresh=Event::where('id',  $event->id)->first();
//        $photo = Photo::first();
//        dd($photo->url);
        $this->assertEquals($photoUrl, $eventFresh->image);
        $this->assertNotNull($eventFresh->image);
//        $this->assertEquals($eventFresh->id, $photo->event->id);
        $event = $event->fresh();
        $this->assertNotNull($event->image);
        $this->assertEquals($photoUrl, $event->image);
//        dd($event->photo->url);
    }
}

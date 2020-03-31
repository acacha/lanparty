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
use File;

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
        Storage::fake('public');
        $event = factory(Event::class)->create();
        $user=$this->loginAsManager('web');
        //pass array with photo and event id
        $response = $this->post('/image/event',[
            'image' => UploadedFile::fake()->image('photo.jpg'),
            'event_id'=>$event->id
        ]);
        $response->assertRedirect();
//      $event = $event->fresh();
//      dd($event->image);
      //see fylesystems.php
        Storage::disk('public')->assertExists($photoUrl='/event_images/' . $event->id . '.jpg');
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
    /**
     * @test
     */
    public function show_event_default_photo()
    {
        $event = factory(Event::class)->create();
        $user=$this->loginAsManager('web');
        $this->withoutExceptionHandling();
        initialize_event_default_image();
        $response = $this->get('/image/event/'.$event->id);
        $response->assertSuccessful();
        $this->assertEquals(storage_path('app/public/'.Event::DEFAULT_PHOTO_PATH), $response->baseResponse->getFile()->getPathName());
        $response->assertSuccessful();
    }
    /** @test */
    public function show_even_photo()
    {
        $this->withoutExceptionHandling();
        //getting the event
        $event = factory(Event::class)->create();
        //login
        $user=$this->loginAsManager('web');
        $response = $this->post('/image/event',[
            'image' => UploadedFile::fake()->image('photo.jpg'),
            'event_id'=>$event->id
        ]);
        //
        $response->assertRedirect();
        $event = $event->fresh();
        $response = $this->get('/image/event/'.$event->id);
        $response->assertSuccessful();
        Storage::disk('public')->assertExists($event->image);

//        dd($event->image);
        $this->assertEquals(storage_path('app/public/'.$event->image), $response->baseResponse->getFile()->getPathName());
        $this->assertFileEquals(storage_path('app/public/'.$event->image), $response->baseResponse->getFile()->getPathName());
        $response->assertSuccessful();
    }
}

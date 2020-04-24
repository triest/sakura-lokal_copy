<?


use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\User::class, 50)->create()->each(function ($user) {
            //  $user->message()->save(factory(App\Message::class)->make());

            $girl = factory(App\Girl::class)->make();
            $girl->save();
            $girl->photos()->save(factory(App\Photo::class)->make());
            $girl->photos()->save(factory(App\Photo::class)->make());
            $girl->photos()->save(factory(App\Photo::class)->make());
            $girl->photos()->save(factory(App\Photo::class)->make());
            $girl->privatephotos()
                ->save(factory(App\Privatephoto::class)->make());

            $target = App\Target::select(['id'])->where('id', 1)->first();

            $girl->target()->attach($target);
            $target = App\Target::select(['id'])->where('id', 2)->first();

            $girl->target()->attach($target);
            $target = App\Target::select(['id'])->where('id', 4)->first();

            $girl->target()->attach($target);
            $target = App\Target::select(['id'])->where('id', 5)->first();
            $target->save();
            $girl->target()->attach($target);


            $user->girl()->save($girl);


        });

    }
}

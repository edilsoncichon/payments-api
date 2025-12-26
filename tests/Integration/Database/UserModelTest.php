<?php

declare(strict_types=1);

namespace Tests\Integration\Database;

use App\Domain\User\Enum\UserType;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function test_create_user()
    {
        $user = new User();
        $user->uuid = Str::uuid()->toString();
        $user->wallet_id = Wallet::factory()->create()->id;
        $user->type = $this->faker->randomElement(UserType::cases());
        $user->document = $this->faker()->numerify('###########');
        $user->full_name = $this->faker()->name();
        $user->email = $this->faker()->email();
        $user->password = $this->faker()->password();

        $user->save();

        $this->assertDatabaseHas(
            'users',
            $user->only(['id', 'uuid', 'wallet_id', 'type', 'document', 'full_name', 'email']),
        );
    }

    public function test_should_fill_fields_correctly()
    {
        /** @var User $model */
        $model = User::factory()->create();

        $this->assertIsInt($model->id);
        $this->assertIsString($model->uuid);
        $this->assertIsInt($model->wallet_id);
        $this->assertIsString($model->full_name);
        $this->assertIsString($model->document);
        $this->assertIsString($model->email);
        $this->assertInstanceOf(UserType::class, $model->type);
        $this->assertInstanceOf(Carbon::class, $model->created_at);
        $this->assertInstanceOf(Carbon::class, $model->updated_at);
    }

    public function test_should_find_user()
    {
        $model = User::factory()->create();
        $findResult = User::query()->findOrFail($model->id);

        $this->assertTrue($findResult->exists);
    }

    public function test_should_destroy_user()
    {
        $model = User::factory()->create();
        $model->delete();
        $this->assertDatabaseMissing('users', ['id' => $model->id]);
    }

    public function test_should_be_linked_to_the_wallet()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $wallet = $user->wallet;
        $this->assertTrue($wallet instanceof Wallet);
    }
}

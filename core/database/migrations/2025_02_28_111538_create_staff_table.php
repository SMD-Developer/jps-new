use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('image')->nullable(); // Image can be null for now
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('department_id');
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->timestamps();

            // Foreign Keys
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff');
    }
};

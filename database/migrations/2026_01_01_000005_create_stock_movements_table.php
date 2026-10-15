<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration {public function up():void{Schema::create('stock_movements',function(Blueprint $t){$t->id();$t->foreignId('product_id')->constrained()->restrictOnDelete();$t->foreignId('user_id')->constrained()->restrictOnDelete();$t->enum('type',['IN','OUT']);$t->unsignedInteger('quantity');$t->string('note',500)->nullable();$t->timestamps();});}public function down():void{Schema::dropIfExists('stock_movements');}};

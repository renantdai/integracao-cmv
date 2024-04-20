<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('cams', function (Blueprint $table) {
            $table->id();
            $table->string('tpAmb')->nullable();
            $table->string('verAplic')->nullable();
            $table->string('tpMan')->nullable();
            $table->string('dhReg')->nullable();
            $table->string('CNPJOper')->nullable();
            $table->string('cEQP')->nullable();
            $table->string('xEQP')->nullable();
            $table->string('cUF')->nullable();
            $table->string('tpSentido')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('tpEQP')->nullable();
            $table->string('xRefCompl')->nullable();
            $table->string('statusSend')->nullable();
            $table->timestamps();
        });
        /*      <tpAmb>1</tpAmb>
        <verAplic>SVRS</verAplic>
        <tpMan>1</tpMan>
        <dhReg>2024-04-17T10:30:00-03:00</dhReg>
        <CNPJOper>88811922000120</CNPJOper>
        <cEQP>000000000026011</cEQP>
        <xEQP>Saida1 - Guaiba x Eldorado (BR)</xEQP>
        <cUF>43</cUF>
        <tpSentido>S</tpSentido>
        <latitude>-30.087322</latitude>
        <longitude>-51.340508</longitude>
        <tpEQP>2</tpEQP>
        <xRefCompl>Passagem da Ponte sentido Tramandai para Imbe usando a faixa da direita</xRefCompl> */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('cams');
    }
};

<?php
trait Hewan{
    public $nama;
    public $darah = 50;
    public $jumlahKaki;
    public $keahlian;

    public function atraksi(){
        echo "{$this->nama} sedang {$this->keahlian}";
    }
}

abstract class Fight{
    use Hewan;
    public $attackPower;
    public $defencePower;

    public function serang($hewan){
        echo "{$this->nama} sedang menyerang {$hewan->nama}";

        $hewan->diserang($this);
    }

    public function diserang($hewan){
        echo "{$this->nama} sedang diserang";
        $this->darah = $this->darah - ($hewan->attackPower / $this->defencePower);
    }

    public function getInfo(){
        echo "<br>";
        echo "Nama: {$this->nama}";
        echo "<br>";
        echo "Jumlah Kaki {$this->jumlahKaki}";
        echo "<br>";
        echo "Jumlah Darah: {$this->darah}";
        echo "<br>";
        echo "Keahlian {$this->keahlian}";
        echo "<br>";
        echo "Attack Power: {$this->attackPower}";
        echo "<br>";
        echo "Defence Power: {$this->defencePower}";
        echo "<br>";

        $this->atraksi();
    }

    abstract public function getInfoHewan();
}

class Spasi{
    public static function spasi(){
        echo "<br>";
        echo "===================================";
        echo "<br>";
    }
}

class Harimau extends Fight{
    public function __construct($name){
        $this->nama = $name;
        $this->jumlahKaki = 4;
        $this->keahlian = "lari cepat";
        $this->attackPower = 7;
        $this->defencePower = 8;
    }

    public function getInfoHewan(){
        echo "Jenis Hewan: Harimau";
        $this->getInfo();
    }
}

class Elang extends Fight{
    public function __construct($name){
        $this->nama = $name;
        $this->jumlahKaki = 2;
        $this->keahlian = "terbang tinggi";
        $this->attackPower = 10;
        $this->defencePower = 5;
    }

    public function getInfoHewan(){
        echo "Jenis Hewan: Elang";
        $this->getInfo();
    }
}

$harimau = new Harimau("Harimau");
$harimau->getInfoHewan();
Spasi::spasi();
$elang = new Elang("Elang");
$elang->getInfoHewan();
Spasi::spasi();

$harimau->serang($elang);
Spasi::spasi();
$elang->getInfoHewan();
Spasi::spasi();

$elang->serang($harimau);
Spasi::spasi();
$harimau->getInfoHewan();
Spasi::spasi();

























?>
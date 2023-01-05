//soal 1
/*
buatlah sebuah function menggunakan arrow function dan template literal untuk menampilkan output seperti dibawah
*/
//jawaban soal no 1
console.log("================== Soal Nomor 1 ========================");
const biodataSiswa = (nama, usia, alamat) => {
    return `Hallo Nama Saya ${nama} usia ${usia} dan saya beralamat di ${alamat}`;
}

console.log(biodataSiswa("regi", 17, "Jl.Sudirman"));



console.log("================== Soal Nomor 2 ========================");
//soal 2
/*
buatlah fungsi luas dan keliling persegi panjang dengan arrow function rumus Luas Persegi panjang(p x l) Keliling persegi panjang (2p + 2l)
*/
//jawaban soal no 2
const luasPersegiPanjang = (p, l) => {
    let hasil = p * l
    console.log(`Luas Lingkarannya Adalah Sebagai Berikut ${hasil}`)
}

const kelPersegiPanjang = (p, l) => {
    let hasil =  (2*p) + (2*l);
    console.log(`keliling perseginya Adalah Sebagai Berikut ${hasil}`)
}

luasPersegiPanjang(3, 5); 
kelPersegiPanjang(3, 6);



console.log("================== Soal Nomor 3 ========================");
//soal no 3
/*
ubah kodingan dibawah menjadi arrow function dan object literal es6 yang lebih sederhana
*/
const newFunction = (firstName, lastName) => {
    const name = { firstName, lastName }
    console.log(`${name.firstName} ${name.lastName}`);
}

  //Driver Code 
newFunction("William", "Imoh")



console.log("================== Soal Nomor 4 ========================");
//soal no 4
/*
Kombinasikan dua array berikut menggunakan array spreading ES6
*/

const west = ["Will", "Chris", "Sam", "Holly"]
const east = ["Gill", "Brian", "Noel", "Maggie"]
const combined = [...west, ...east];
//Driver Code
console.log(combined)


console.log("================== Soal Nomor 5 ========================");
//soal no 5
/*
buatlah function untuk menghitung berapa jumlah huruf vocal pada parameter string gunaka arrow function
*/
const hitungVokal = (str) => {
    const lowercase = str.toLowerCase();
    const hasil = [...lowercase];
    let output = 0;
    hasil.forEach((item) => {
        if(item === "a" || item === "i" || item === "u" || item === "e" || item === "o"){
            output++;
        }
    });
    return output;
}

console.log(hitungVokal("Adonis"))// Output:3
console.log(hitungVokal("Error"))//Output:2
console.log(hitungVokal("Eureka"))//Output:4
console.log(hitungVokal("Rsch")) // Output: 0
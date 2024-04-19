// Format mata uang rupiah (contoh Rp 10.000)
function formatMoney(number) {
    number = new Number(number);
    return "Rp " + number.toLocaleString("id-ID");
}

// Format angka dengan separator (contoh: 10.000)
function formatNumber(number) {
    number = new Number(number);
    return number.toLocaleString("id-ID");
}

// Format tanggal (contoh: 17 Agustus 1945)
function formatDate(date) {
    return moment(date).locale("id").format("D MMMM YYYY");
}

// Format tanggal (contoh: 17 Agustus 1945)
function formatDateYear(date) {
    return moment(date).locale("id").format("YYYY");
}

// Format tanggal pendek (contoh: 17 Agu 1945)
function formatDateShort(date) {
    return moment(date).locale("id").format("D MMM YYYY");
}

// Format tanggal dan waktu pendek (contoh: 17 Agu 1945 00:00)
function formatDateTimeShort(date) {
    return moment(date).locale("id").format("D MMM YYYY HH:mm");
}

function formatDateTimeNumber(date) {
    return moment(date).locale("id").format("D-MM-YYYY h:m");
}

// Format tanggal dan waktu (contoh: 17 Agustus 1945 00:00)
function formatDateTime(date) {
    return moment(date).locale("id").format("D MMMM YYYY HH:mm");
}

// Format tanggal dan waktu (contoh: 17 Agustus 1945 00:00:00)
function formatDateTimeSecond(date) {
    return moment(date).locale("id").format("D MMMM YYYY HH:mm:ss");
}

// Format waktu (contoh: 00:00)
function formatTime(date) {
    return moment(date).locale("id").format("HH:mm");
}

// Format angka dengan prefix 0 jika angka < 10 (contoh: 09)
function addZeroBefore(n) {
    return (n < 10 ? "0" : "") + n;
}

// Format angka dari hari menjadi nama hari
function getDayName(daynumber) {
    var daynames = [
        "-",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu",
        "Minggu",
    ];

    return daynames[daynumber];
}

// Kapitalisasi teks
function capitalize(string) {
    var splitStr = string.toLowerCase().split(" ");
    for (var i = 0; i < splitStr.length; i++) {
        // You do not need to check if i is larger than splitStr length, as your for does that for you
        // Assign it back to the array
        splitStr[i] =
            splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
    }
    // Directly return the joined string
    return splitStr.join(" ");
}

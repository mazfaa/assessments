$(document).ready(function() {
    function formatRupiah(numbers) {
        let number_string = numbers.replace(/[^,\d]/g, "").toString();
        let split = number_string.split(",");
        let remainder = split[0].length % 3;
        let rupiah = split[0].substr(0, remainder);
        let thousands = split[0].substr(remainder).match(/\d{3}/gi);

        if (thousands) {
            let separator = remainder ? "." : "";
            rupiah += separator + thousands.join(".");
        }

        rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
        return "Rp. " + rupiah;
    }

  $(".price-format").each(function () {
      $(this).on("input", function() {
        $(this).val(formatRupiah($(this).val()));
      })
    });
  
  $("form").on("submit", function (e) {
        $(".price-format").each(function() {
            let numbers = $(this).val().replace(/[^\d]/g, "");
            $(this).val(Number(numbers));
        });
    });
});
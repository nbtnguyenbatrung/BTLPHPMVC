function sosao(){
    $.ajax({
        type: "get",
        url: "http://localhost:9999/sosao",
        dataType: "json",
        success: function(value) {
            addsosao(value);
        }
    });
}

function addsosao(data){
    var rating = "";
    if(data == null ){
        rating = getRateStar(0);
    }else{
        rating = getRateStar(data);
    }
}

function getRateStar(num){
    var result = "";
        for (var i = 1; i <= 5; i++) {
            if (i <= num) {
                result += `<i class="fa fa-star"></i>`
            } else {
                result += `<i class="fa fa-star-o"></i>`
            }
        }
        return result;
}

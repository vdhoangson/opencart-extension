$(document).ready(function() {

    $('.btn-group').click(function() {
        $(this).find('.btn').toggleClass('active');  
        
        if ($(this).find('.btn-primary').size()>0) {
            $(this).find('.btn').toggleClass('btn-primary');
        }
        
        $(this).find('.btn').toggleClass('btn-default');
           
    });

	/* Auto fill seo keyword */

    var keyword = $("input[name=keyword]");

    $("input[name^='article_description'],input[name^='category_description']").keyup(function() {
        var  SEOlink = $("input[name^='article_description'],input[name^='category_description']").val();
        
        SEOlink = SEOlink.replace(/^\s+|\s+$/g, ''); // trim
        SEOlink = SEOlink.toLowerCase();

        SEOlink = SEOlink.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
        SEOlink = SEOlink.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
        SEOlink = SEOlink.replace(/ì|í|ị|ỉ|ĩ/g,"i");
        SEOlink = SEOlink.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
        SEOlink = SEOlink.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
        SEOlink = SEOlink.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
        SEOlink = SEOlink.replace(/đ/g,"d");
        SEOlink = SEOlink.replace(/!|@|\$|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\'| |\"|\&|\#|\[|\]|~/g,"-");
        SEOlink = SEOlink.replace(/-+-/g,"-"); //thay thế 2- thành 1-
        SEOlink = SEOlink.replace(/^\-+|\-+$/g,"");//cắt bỏ ký tự - ở đầu và cuối chuỗi
        
        SEOlink = SEOlink.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

        keyword.val(SEOlink);

    });
});
$(document).ready(function () {

    $('tr').click(function() {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            $(this).removeClass('table-warning');
            document.getElementById("primaryKey").innerHTML = 'primaryKey';
        }
        else {
            $(this).addClass('selected').siblings().removeClass('selected');
            $(this).siblings().removeClass('table-warning');
            $(this).addClass('table-warning');
            console.log('selected: ', $(this));
            cells = $(this).find('td');

            reference=document.getElementById("primaryKeyPlace").innerHTML;
            selected_ref = cells.eq(reference - 1).html();
            console.log('selected ref: ', selected_ref);
            document.getElementById("primaryKey").innerHTML = selected_ref.replace(/\s/g, '');
        }
    });

    var rowsShown = document.getElementById("showRowNumber").innerHTML;
    console.log(rowsShown);

    var rowsTotal = $('.sm-lego-table tbody tr').length;
    var pagesNums = rowsTotal/rowsShown;
    console.log(pagesNums);

    var pageNum = 0;
    var activePage = 1;
    var previousPage = activePage - 1;
    var nextPage = +activePage + 1;

    $('a', $('.sm-lego-table-dropdown-menu li').find(":contains('" + rowsShown + "')").addClass('active'));

    $('.sm-lego-table').after(function () {
        $('.sm-lego-table').after("<nav id='sm-lego-table-pag-nav' aria-label='Page navigation example'>");
        $('#sm-lego-table-pag-nav').append("<ul class='pagination justify-content-end'>");
        $('.pagination').append("<li class='page-item disabled sm-lego-table-pag-prev'><a class='page-link' href='#' rel='" + previousPage + "' aria-label='Previous' >&laquo;</a></li>");
        
        for (i=0; i < pagesNums; i++) {
            pageNum = i + 1;
            $('.pagination li:last-of-type').after("<li id='sm-lego-table-pag-item-" + pageNum + "' class='page-item'><a class='page-link' href='#' rel='" + pageNum + "'>" + pageNum + "</a></li>")
        }
        $('.pagination li:last-of-type').after("<li class='page-item sm-lego-table-pag-next'><a class='page-link' href='#' rel='" + nextPage + "' aria-label='Previous' >&raquo;</a></li></ul>");
        $('ul').after("</nav>");
    });

    $('.sm-lego-table tbody tr').hide();
    $('.sm-lego-table tbody tr').slice(0, rowsShown).show();
    $('.pagination').css('--bs-pagination-disabled-bg', 'lightgrey');
    $('.pagination').css('--bs-pagination-active-bg', 'rgb(113,187,198)');
    $('.pagination').css('--bs-pagination-active-border-color', 'rgb(113,187,198)');
    $('.sm-lego-table-pag-prev').addClass('disabled');
    $('#sm-lego-table-pag-nav ul li:nth-child(2)').addClass('active');
    if ($('#sm-lego-table-pag-nav ul li').length == 3) {
        $('.sm-lego-table-pag-next').addClass('disabled');
    }

    $('#sm-lego-table-pag-nav a').bind('click', function () {
        $('#sm-lego-table-pag-nav ul li').removeClass('active');
        $('#sm-lego-table-pag-nav ul li').removeClass('disabled');
        activePage = $(this).attr('rel');

        console.log('parent', $(this).parent())
        $(this).parent().addClass('active');
        $('#sm-lego-table-pag-item-' + activePage).addClass('active');

        console.log('pagenum', pageNum, 'activepage', activePage);

        previousPage = activePage - 1;
        nextPage = +activePage + 1;
        console.log('previouspage',previousPage, 'nextpage',nextPage);

        $('.sm-lego-table-pag-prev a').attr('rel', previousPage);
        $('.sm-lego-table-pag-next a').attr('rel', nextPage);

        if (previousPage == 0) {
            $('.sm-lego-table-pag-prev').addClass('disabled');
        }

        if (nextPage > pageNum) {
            $('.sm-lego-table-pag-next').addClass('disabled');
        }

        var startItem = (activePage - 1) * rowsShown;
        var endItem = startItem + parseInt(rowsShown, 10);
        console.log('startItem',startItem, 'endItem',endItem);

        $('.sm-lego-table tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).css('display', 'table-row').animate({opacity:1}, 300);

    });

    $('#sm-lego-table-search-input').on('keyup', function () {
        var searchValue = $(this).val().toLowerCase();
        // console.log('this', this);
        console.log('value', searchValue);
        $('.sm-lego-table tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1).css('opacity', '1');
        });
        if (searchValue == '') {
            console.log('empty');
            location.reload();
        };
    });

    document.getElementById("sm-lego-table-search-input").addEventListener("search", function(event) {
        console.log('clear');  
        location.reload();
    });

    $('.sm-lego-table-dropdown-menu li').on('click', function(){
        console.log('dropdown');
        rowsShown = $(this).text();
        console.log($(this).text());
        $('.sm-lego-table-dropdown-menu li a').removeClass('active');
        $('a', this).addClass('active');
        console.log(location);
        pathname = location.href.substring(0,location.href.indexOf('HOME'));
        console.log(pathname);
        location.href = pathname + 'COURANT/table/' + rowsShown;
    });

    if (document.getElementById("sm-lego-navbar-link-delete-img") != null) {
        document.getElementById("sm-lego-navbar-link-delete-img").addEventListener("click", function(event) {
        if (document.getElementById("primaryKey").innerHTML == 'primaryKey') {
            alert("NOTHING SELECTED")
        }
        else {
	        var reference=document.getElementById("primaryKey").innerHTML
            var name=document.getElementById("primaryKeyName").innerHTML;
            var pathname='HOME';

	        // var language=document.getElementById("language").innerHTML
	        // var originSite=document.getElementById("originSite").innerHTML
            console.log("***" + reference + '****');
            console.log("***" + name + '****');
            // console.log(originSite + "/public/Delete_form.php?Ref=" + reference)
             // window.open(originSite + '/public/Delete_form.php?lang=' + language + '&Ref=' + reference, '_blank').focus;
            console.log(location)
             // location.href = 'https://' + location.host + '/DEV_SMWEB/public/DB/LEGO/HOME/' + rowsShown;
             if (location.href.includes('USER')) {
                // user = location.href.substring(location.href.lastIndexOf('/')+1);
                // console.log(" USER: " + user);
                // console.log(" LOCATION: " + location.href);
                pathname = location.href.substring(0,location.href.indexOf('USER'));
                console.log(" PATHNAME: " + pathname);
            }
            else {
                pathname = location.href.substring(0,location.href.indexOf('HOME'));
            }
            console.log(pathname);
             window.open(pathname + 'DELETE/' + name + '/' + reference, '_blank').focus;
         }
        });
    }

    if (document.getElementById("sm-lego-navbar-link-archive-img") != null) {
        document.getElementById("sm-lego-navbar-link-archive-img").addEventListener("click", function(event) {
            if (document.getElementById("primaryKey").innerHTML == 'primaryKey') {
                alert("NOTHING SELECTED")
            }
            else {
                var reference=document.getElementById("primaryKey").innerHTML
                var name=document.getElementById("primaryKeyName").innerHTML;
                var pathname='HOME';

                // var language=document.getElementById("language").innerHTML
                // var originSite=document.getElementById("originSite").innerHTML
                console.log("***" + reference + '****');
                console.log("***" + name + '****');
                // console.log(originSite + "/public/Delete_form.php?Ref=" + reference)
                // window.open(originSite + '/public/Delete_form.php?lang=' + language + '&Ref=' + reference, '_blank').focus;
                console.log(location)
                // location.href = 'https://' + location.host + '/DEV_SMWEB/public/DB/LEGO/HOME/' + rowsShown;
                if (location.href.includes('USER')) {
                    // user = location.href.substring(location.href.lastIndexOf('/')+1);
                    // console.log(" USER: " + user);
                    // console.log(" LOCATION: " + location.href);
                    pathname = location.href.substring(0,location.href.indexOf('USER'));
                    console.log(" PATHNAME: " + pathname);
                }
                else {
                    pathname = location.href.substring(0,location.href.indexOf('HOME'));
                }
                console.log(pathname);
                window.open(pathname + 'ARCHIVE/' + name + '/' + reference, '_blank').focus;
            }
        });
    }
    if (document.getElementById("sm-lego-navbar-link-unarchive-img") != null) {
        document.getElementById("sm-lego-navbar-link-unarchive-img").addEventListener("click", function(event) {
        if (document.getElementById("primaryKey").innerHTML == 'primaryKey') {
            alert("NOTHING SELECTED")
        }
        else {
	        var reference=document.getElementById("primaryKey").innerHTML
            var name=document.getElementById("primaryKeyName").innerHTML;
            var pathname='HOME';

	        // var language=document.getElementById("language").innerHTML
	        // var originSite=document.getElementById("originSite").innerHTML
            console.log("***" + reference + '****');
            console.log("***" + name + '****');
            // console.log(originSite + "/public/Delete_form.php?Ref=" + reference)
             // window.open(originSite + '/public/Delete_form.php?lang=' + language + '&Ref=' + reference, '_blank').focus;
            console.log(location)
             // location.href = 'https://' + location.host + '/DEV_SMWEB/public/DB/LEGO/HOME/' + rowsShown;
             pathname = location.href.substring(0,location.href.indexOf('HOME'));
             console.log(pathname);
             window.open(pathname + 'UNARCHIVE/' + name + '/' + reference, '_blank').focus;
         }
        });
    }


    if (document.getElementById("sm-lego-navbar-link-edit-img") != null) {
        document.getElementById("sm-lego-navbar-link-edit-img").addEventListener("click", function(event) {
        if (document.getElementById("primaryKey").innerHTML == 'primaryKey') {
            alert("NOTHING SELECTED")
        }
        else {
	        var reference=document.getElementById("primaryKey").innerHTML
            var name=document.getElementById("primaryKeyName").innerHTML;
            var pathname='HOME';
            var user='USER';

	        // var language=document.getElementById("language").innerHTML
	        // var originSite=document.getElementById("originSite").innerHTML
            console.log("***" + reference + '****');
            console.log("***" + name + '****');
            console.log(location)
             // location.href = 'https://' + location.host + '/DEV_SMWEB/public/DB/LEGO/HOME/' + rowsShown;

            if (location.href.includes('USER')) {
                // user = location.href.substring(location.href.lastIndexOf('/')+1);
                // console.log(" USER: " + user);
                // console.log(" LOCATION: " + location.href);
                pathname = location.href.substring(0,location.href.indexOf('USER'));
                console.log(" PATHNAME: " + pathname);
            }
            else {
                pathname = location.href.substring(0,location.href.indexOf('HOME'));
            }
            console.log(pathname);
            window.open(pathname + 'EDIT/' + name + '/' + reference, '_blank').focus;
        }
        });
    }
});
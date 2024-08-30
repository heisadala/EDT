$(document).ready(function () {

    $('.edt-chkbx').on('change', function(){


        let checkEle = document.querySelectorAll(".edt-chkbx");
        console.log(checkEle);

        checkEle.forEach((item, index) => { 
            console.log(item.innerText);
            console.log(item.control.checked);
   
            if(item.control.checked) {
                pathname = location.href.substring(0,location.href.indexOf('CHART'));
                console.log(pathname);
                console.log(pathname + 'CHART/' + item.innerText, '_blank');
                // window.open(pathname + 'DELETE/' + name + '/' + reference, '_blank').focus;
            //     alert('Hello checked' )
            // } else {
            //     alert('Hallo not checked')
            }    
        })       
    })
})
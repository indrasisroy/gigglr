function poptriggerfunc(msgtype,titledata,msgdata,sd,hd,tmo,etmo,poscls)
{
    
    toastr.options = {
                closeButton: true,
                progressBar: false,
                positionClass: poscls,                
                onclick: null,
                showDuration: sd,
                hideDuration: hd,
                timeOut: tmo,
                extendedTimeOut: etmo,
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"                
                
            };
            
            toastr[msgtype](titledata, msgdata);
}
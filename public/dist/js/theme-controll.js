$("#sidebar_controller .custom-control-input").on('click', function () {
    let target = $(this).data('target');
    let targetClass = $(this).attr('id');


    let targetClassName = "";
    if(targetClass == 'sidebar-light-primary'){
        targetClassName = this.checked ? 'sidebar-light-primary' : 'sidebar-dark-primary';
        $(`${target}`).removeClass('sidebar-light-primary sidebar-dark-primary');
        $(`${target}`).toggleClass(`${targetClassName}`);
    }
    else if( targetClass == 'navbar-light'){
        targetClassName = this.checked ? 'navbar-light' : 'navbar-dark';
        $(`${target}`).removeClass('navbar-light navbar-dark');
        $(`${target}`).toggleClass(`${targetClassName}`);
    }
    else if( targetClass == 'bg-white'){
        targetClassName = this.checked ? 'bg-white' : 'bg-dark';
        $(`${target}`).removeClass('bg-white bg-dark');
        $(`${target}`).toggleClass(`${targetClassName}`);
    }
    else{
        targetClassName = this.checked ? targetClass : "";
        $(`${target}`).toggleClass(`${targetClass}`);
    }
    if(this.checked){
        localStorage.setItem(`setting_${targetClass}`,JSON.stringify({targetClass:targetClassName, target}));  
    }else{
        localStorage.setItem(`setting_${targetClass}`,JSON.stringify({targetClass:targetClassName, target}));
    }
});

$(document).ready(function () {
    let theme_setting = Object.entries(localStorage).filter((item)=> item[0].includes('setting'));
    theme_setting.forEach(element => {
        let [target,value] = element
        value = JSON.parse(value);
        let target_id = "[id*='" +value.targetClass+ "']";
        $(target_id).prop('checked', !$(target_id).prop("checked"));
        if(value.targetClass == 'sidebar-light-primary' || value.targetClass == 'sidebar-dark-primary'){
            $(`${value.target}`).removeClass('sidebar-dark-primary sidebar-light-primary');
        }
        else if(value.targetClass == 'navbar-light' || value.targetClass == 'navbar-dark'){
            $(`${value.target}`).removeClass('navbar-light navbar-dark');
        }
        else if(value.targetClass == 'bg-white' || value.targetClass == 'bg-dark'){
            $(`${value.target}`).removeClass('bg-white bg-dark');
        }
        $(`${value.target}`).toggleClass(`${value.targetClass}`);
       
    });
});
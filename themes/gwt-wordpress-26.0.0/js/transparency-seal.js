document.addEventListener('DOMContentLoaded',() => {
    //parent
    const sealContentWrapper = document.getElementById('seal-content-wrapper');
    console.log('the workflow workS');
    /*
     #unhide list if title is clicked
     #only hide list with similar data id to targeted element
    */ 
    sealContentWrapper.querySelectorAll('.seal-section-wrapper').forEach(sections => {
        sections.addEventListener('click', e => {
           const titleID = e.target.dataset.id;
           const lists =  e.currentTarget.querySelectorAll('.seal-list-wrapper');
           const icons = e.currentTarget.querySelectorAll('.dashicons');
           
           icons.forEach(icon => {
             if(titleID == icon.dataset.id){
                swapIcon(icon);
             }
           })

           
            lists.forEach(element => {
                if(titleID == element.dataset.id){
                   swapClass(element)
                }
            });

        // HELPER FUNCTIONS 
        // remove or add d-none when clicked
            function swapClass(element){
               if(element.classList.contains('d-none')){
                 element.classList.remove('d-none');
               }else{
                 element.classList.add('d-none');
               }
            }
            // swap plus - minus | icon
            function swapIcon(icon){
                if(icon.classList.contains('dashicons-plus-alt2')){
                    icon.classList.remove('dashicons-plus-alt2');
                   icon.classList.add('dashicons-minus');
                }else{
                    icon.classList.remove('dashicons-minus');
                   icon.classList.add('dashicons-plus-alt2');
                }
            }
        })
    });;


});
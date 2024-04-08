document.getElementById("confirmDelete").addEventlistener('click', async ()=>{
    let id = document.getElementById("deleteID").value;
    document.getElementById("delete-modal-close").click();
    showLoader();
    let res = await axios.post('/api/delete-category', {id:id});
    hideLoader();
    if(res.data === 1){
        successToast("Request Completed");
        await getList();
    }else{
        errorToast("Request Failed");
    }
    
 });

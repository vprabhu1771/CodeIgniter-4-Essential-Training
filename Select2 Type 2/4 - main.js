$(document).ready(function(){

    console.log('Document is ready');

    // Initialize Select2 for category dropdown
    $('.category-select').select2({
        placeholder: 'Select a category',
        allowClear: true
    }).on('select2:open', function() {
        console.log('Select2 is initialized and opened.');
    });

    
    // Get selected value on close of the dropdown
    $('.category-select').on('select2:close', function() {
        var element = $(this);
        var selected_category = $.trim(element.val());  // Get the selected value

        console.log(selected_category);  // Log the selected value to the console

        // You can now use this value to perform any other actions
        // For example, you could send an AJAX request or update other parts of the UI
    });
    
});
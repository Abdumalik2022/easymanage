class Notification {
   success() {
      new Noty({
         type: "success",
         text: 'Successfully Done',
         layout: "topRight",
         timeout: 1000
      }).show();
   }

   deleted() {
      new Noty({
         type: "success",
         text: 'Successfully Deleted',
         layout: "topRight",
         timeout: 1000
      }).show();
   }

   AddToCart() {
      new Noty({
         type: "success",
         text: 'Successfully Added to Card',
         layout: "topRight",
         timeout: 1000
      }).show();
   }

   alert() {
      new Noty({
         type: "alert",
         text: 'Are you sure ?',
         layout: "topRight",
         timeout: 1000
      }).show();
   }

   error() {
      new Noty({
         type: "error",
         text: 'Something went wrong',
         layout: "topRight",
         timeout: 1000
      }).show();
   }

   warning() {
      new Noty({
         type: "warning",
         text: 'Oopps Wrong',
         layout: "topRight",
         timeout: 1000
      }).show();
   }

   image_validation() {
      new Noty({
         type: "error",
         text: 'Image must be less than 1MB',
         layout: "topRight",
         timeout: 2000
      }).show();
   }
}

export default Notification = new Notification();
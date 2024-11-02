import'./bootstrap';
window.Echo.channel('broadcast-coupon').listen('CouponEvent', function(event){
    console.log(event);
})
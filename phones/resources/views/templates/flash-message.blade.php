@if ($message = Session:: get("update"))
<script>
    M.toast({html: " {{ $message }} "})
</script>    
@endif

@if ($message = Session:: get("delete"))
<script>
    M.toast({html: " {{ $message }} "})
</script>      
@endif

@if ($message = Session:: get("create"))
<script>
    M.toast({html: " {{ $message }} "})
</script>     
@endif
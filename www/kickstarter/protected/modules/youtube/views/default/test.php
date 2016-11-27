<form id="form">
  <input id="txt-title" type="text"/>
  <input id="video" name="file" type="file"/>
  <input value="Upload Video File" type="submit" />
</form>

<script>
  $(document).ready(function(){
    $('#form').submit(function(){
      var iframe = document.createElement('iframe');
      iframe.src = "/youtube?title=" + $('#txt-title').val() + '&description=a&file=' + $("#video").val()
      // iframe.style.display = "none";
      $('body').append(iframe);
      return false;
    });
  });
</script>
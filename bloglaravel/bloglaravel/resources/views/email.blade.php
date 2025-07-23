<form action="/send" method="POST">
    @csrf
    <input type="text" name="name" value="narendra">
    <input type="email" name="email" value="narendra@gmail.com">
    <input type="text" name="subject" value="subject here">
    <input type="text" name="message" value="your message">
    <button type="submit">Submit</button>
</form>

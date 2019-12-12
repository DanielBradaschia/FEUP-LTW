<form method="get" action="searchPlaces.php" class="action-wrapper">
    <input id="addressSearch" class="select-location" type="text" value="" name="location" placeholder="Location">
    <input class="search-bar" type="text" name="place" placeholder="Search for places...">
    <input placeholder="MoveIn" class="search-date" type="text"
        onfocus="(this.type='date')" onblur="(this.type='text')" name="movein"><br>
    <input placeholder="MoveOut" class="search-date" type="text"
        onfocus="(this.type='date')" onblur="(this.type='text')" name="moveout"><br>
    <input class="button" type="submit" name="submit" value="Search">
</form>

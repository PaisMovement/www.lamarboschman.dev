<?php
foreach ($_POST as $keys=>$values) {
	$$keys = $values;
}
?>
<li id="edit_track<?php echo $counter_track?>">
<div>
    <ul class="to-rows to-cont">
        <li class="album-title" id="album-title<?php echo $counter_track?>" ><?php echo $album_track_title?></li>
        <li class="actions">
            <a onclick="javascript:return confirm('Are you sure! You want to delete this Track')" href="javascript:cs_div_remove('edit_track<?php echo $counter_track?>')" class="ac-close">&nbsp;</a>
            <a href="javascript:addtrack('edit_track_form<?php echo $counter_track?>')" class="ac-edit">&nbsp;</a>
        </li>
    </ul>  

	<div class="poped-up" id="edit_track_form<?php echo $counter_track?>">
        <div class="opt-head">
            <h6>Track Settings</h6>
            <a href="javascript:closetrack('edit_track_form<?php echo $counter_track?>')" class="closeit">&nbsp;</a>
        </div>
        <ul class="form-elements">
            <li class="to-label"><label>Track Title</label></li>
            <li class="to-field"><input type="text" name="album_track_title[]" value="<?php echo htmlspecialchars($album_track_title)?>" id="album_track_title<?php echo $counter_track?>" /></li>
            <li class="to-desc"><p>Put album track title</p></li>
        </ul>
        <ul class="form-elements">
            <li class="to-label"><label>Track MP3 URL</label></li>
            <li class="to-field">
                <input id="album_track_mp3_url<?php echo $counter_track?>" name="album_track_mp3_url[]" value="<?php echo htmlspecialchars($album_track_mp3_url)?>" type="text" size="36" />
                <input id="album_track_mp3_url<?php echo $counter_track?>" name="album_track_mp3_url<?php echo $counter_track?>" type="button" class="uploadfile left" value="Browse"/>
            </li>
            <li class="to-desc"><p>Put album track mp3 url</p></li>
        </ul>
        <ul class="form-elements">
            <li class="to-label"><label>Playable</label></li>
            <li class="to-field">
                <select name="album_track_playable[]" class="dropdown">
                    <option <?php if($album_track_playable=="Yes")echo "selected";?> >Yes</option>
                    <option <?php if($album_track_playable=="No")echo "selected";?> >No</option>
                </select>
            </li>
            <li class="to-desc"><p>Make Playable on/off</p></li>
        </ul>
        <ul class="form-elements">
            <li class="to-label"><label>Downloadable</label></li>
            <li class="to-field">
                <select name="album_track_downloadable[]" class="dropdown">
                    <option <?php if($album_track_downloadable=="Yes")echo "selected";?> >Yes</option>
                    <option <?php if($album_track_downloadable=="No")echo "selected";?> >No</option>
                </select>
            </li>
            <li class="to-desc"><p>Make Playable on/off</p></li>
        </ul>
        <ul class="form-elements">
            <li class="to-label"><label>Lyrics</label></li>
            <li class="to-field">
                <textarea name="album_track_lyrics[]"><?php echo htmlspecialchars($album_track_lyrics)?></textarea>
            </li>
            <li class="to-desc"><p>Put album track mp3 url</p></li>
        </ul>
        <ul class="form-elements">
            <li class="to-label"><label>Buy MP3 URL</label></li>
            <li class="to-field"><input type="text" name="album_track_buy_mp3[]" value="<?php echo htmlspecialchars($album_track_buy_mp3)?>" /></li>
            <li class="to-desc"><p>Put album track mp3 url</p></li>
        </ul>
        <ul class="form-elements noborder">
            <li class="to-label"></li>
            <li class="to-field"><input type="button" value="Update Track" onclick="update_title(<?php echo $counter_track?>); closetrack('edit_track_form<?php echo $counter_track?>')" /></li>
        </ul>
    </div>

</div>
</li>
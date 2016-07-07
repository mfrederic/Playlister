			<tr>
				<td class="music_selector" style="text-align: center;"><input type="checkbox" name="musics[]" value="<?= $music->music_id; ?>"></td>
				<td><img src="<?= $music->music_poster; ?>" alt="poster" /></td>
				<td class="music_title" title="Ajoutée le <?= date('d/m/Y', strtotime($music->music_add)); ?>">
					<a title="lire" href="javascript:;" onclick="myPlaysliter.add({
							title:'<?= escape_chars($music->music_title); ?>',
							artist:'<?= empty(trim(escape_chars($music->music_band))) ? 'Inconnu' : escape_chars($music->music_band); ?>',
							mp3:'<?= escape_chars(get_music_url($music->music_url)); ?>',
							poster: '<?= (empty($music->music_poster)) ? escape_chars(get_music_poster($music->music_band, $music->music_title)) : escape_chars($music->music_poster); ?>'
						}, true);"><?= $music->music_title; ?></a>
				</td>
				<td><?= $music->music_band; ?></td>
				<td style="text-align: center;"><?= ($music->music_year == null) ? '-' : $music->music_year; ?></td>
				<td><?
					if(empty($music->styles))
						echo '-'
					else {
						$liststyles = array();
						foreach ($music->styles as $style)
							$liststyles[] = $style->style_name;
						echo implode(', ', $liststyles);
					}
				 ?></td>
				<td>
					<a title="ajouter à la lecture" class="icon-play" href="javascript:;"
						onclick="myPlaysliter.add({
							title:'<?= escape_chars($music->music_title); ?>',
							artist:'<?= empty(trim(escape_chars($music->music_band))) ? 'Inconnu' : escape_chars($music->music_band); ?>',
							mp3:'<?= escape_chars(get_music_url($music->music_url)); ?>',
							poster: '<?= (empty($music->music_poster)) ? escape_chars(get_music_poster($music->music_band, $music->music_title)) : escape_chars($music->music_poster); ?>'
						}); $('#music_<?= $music->music_id; ?>').alertize('ajouter à la lecture');"></a>
					<a title="ajouter à une playlist" class="icon-plus" href="javascript:;"
						onclick="add_to_playlist_phase_1($(this)); return false;" data-music-id="<?= $music->music_id; ?>" data-url="<?= site_url('playlist/list'); ?>"></a>
				</td>
			</tr>
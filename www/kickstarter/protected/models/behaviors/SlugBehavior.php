<?php
/**
 * SlugBehavior
 *
 * Saves pretty url's from titles to be used as unique identifier's
 *
 * @author Chris de Kok <chris.de.kok@gmail.com>
 * @copyright Copyright (c) 2009 Chris de Kok. (http://mech7.net)
 *
 */
class SlugBehavior extends CActiveRecordBehavior {

    /**
    * The column name for the unqiue url
    */
    public $slug_col = 'slug';

    /**
    * The column name for the unqiue url
    */
    public $title_col = 'title';

    public $changeable_check = 'changeableCheck';

	/**
	 * Primary key column name needs to be an id
	 * @var string
	 */
	 protected $pk_col;

    /**
     * Overwrite slug when updating
     */
     public $overwrite = true;

     /**
      * Decode url only usefull if you want to support high unicode characters in url
      */
     public $url_decode = true;

    /**
     * Before saving to database
     */
    public function beforeSave($event) {

        if($this->Owner->isNewRecord || ($this->overwrite === true && $this->owner->{$this->changeable_check}())) {
            $slug = $this->getUniqueSlug();
            $this->Owner->{$this->slug_col} = $slug;
        }

		return true;
    }

    public function changeableCheck() {
      return true;
    }

    /**
     * Checks the database to return the unique slug from the database
     * @param string $slug
     */
    public function getUniqueSlug()
    {
        $slug = $this->getSlug($this->Owner->{$this->title_col});
        $this->pk_col = $this->Owner->getMetaData()->tableSchema->primaryKey;
        $this->Owner->{$this->slug_col} = $slug;

        $matches = $this->getMatches($this->Owner->slug);

        if($matches){
			$ar_matches = array();
			foreach ($matches as $match){
				if($match->{$this->pk_col} == $this->Owner->{$this->pk_col} && $match->{$this->slug_col} == $this->Owner->{$this->slug_col}){
				} else {
					$ar_matches[] = $match->slug;
				}
			}

			$new_slug = $slug;
			$index = 1;
			while ($index > 0) {
				if (in_array($new_slug, $ar_matches)){
					$new_slug = $slug.'-'.$index;
					$index++;
				} else {
					$slug = $new_slug;
					$index = -1;
				}
			}
		}
        return $slug;
    }

    /**
     * Lookup if string already exists in database
     * @param string $title
     */
    public function getMatches($slug)
    {
        $slugs = $this->Owner->findAll(array(
            'select'=> $this->slug_col.' , '.$this->title_col.' , '.$this->pk_col,
            'condition'=> $this->slug_col." LIKE '%".$slug."%'"
        ));
        return $slugs;
    }


    /**
     * Sanitizes title, replacing whitespace with dashes.
     *
     * Limits the output to alphanumeric characters, underscore (_) and dash (-).
     * Whitespace becomes a dash.
     *
     * @param string $title The title to be sanitized.
     * @return string The sanitized title.
     */
    public function getSlug($title)
    {
        $title = strip_tags($title);
        // Preserve escaped octets.
        $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
        // Remove percent signs that are not part of an octet.
        $title = str_replace('%', '', $title);
        // Restore octets.
        $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

        $title = $this->remove_accents($title);

        $title = strtolower($title);
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = str_replace('.', '-', $title);
        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);
        $title = trim($title, '-');

        if($this->url_decode){
            $title = urldecode($title);
        }

        return $title;
    }

    /**
     * Converts all accent characters to ASCII characters.
     *
     * If there are no accent characters, then the string given is just returned.
     *
     * @param string $string Text that might have accent characters
     * @return string Filtered string with replaced "nice" characters.
     */
    private function remove_accents($s)
    {
      $original_string = $s;
      // maps German (umlauts) and other European characters onto two characters before just removing diacritics
      $s    = preg_replace( '@\x{00c4}@u'    , "AE",    $s );    // umlaut Ä => AE
      $s    = preg_replace( '@\x{00d6}@u'    , "OE",    $s );    // umlaut Ö => OE
      $s    = preg_replace( '@\x{00dc}@u'    , "UE",    $s );    // umlaut Ü => UE
      $s    = preg_replace( '@\x{00e4}@u'    , "ae",    $s );    // umlaut ä => ae
      $s    = preg_replace( '@\x{00f6}@u'    , "oe",    $s );    // umlaut ö => oe
      $s    = preg_replace( '@\x{00fc}@u'    , "ue",    $s );    // umlaut ü => ue
      $s    = preg_replace( '@\x{00f1}@u'    , "ny",    $s );    // ñ => ny
      $s    = preg_replace( '@\x{00ff}@u'    , "yu",    $s );    // ÿ => yu

      // maps special characters (characters with diacritics) on their base-character followed by the diacritical mark
      // exmaple:  Ú => U´,  á => a`
      $s    = Normalizer::normalize( $s, Normalizer::FORM_D );

      $s    = preg_replace( '@\pM@u'        , "",    $s );    // removes diacritics

      $s    = preg_replace( '@\x{00df}@u'    , "ss",    $s );    // maps German ß onto ss
      $s    = preg_replace( '@\x{00c6}@u'    , "AE",    $s );    // Æ => AE
      $s    = preg_replace( '@\x{00e6}@u'    , "ae",    $s );    // æ => ae
      $s    = preg_replace( '@\x{0132}@u'    , "IJ",    $s );    // ? => IJ
      $s    = preg_replace( '@\x{0133}@u'    , "ij",    $s );    // ? => ij
      $s    = preg_replace( '@\x{0152}@u'    , "OE",    $s );    // Œ => OE
      $s    = preg_replace( '@\x{0153}@u'    , "oe",    $s );    // œ => oe

      $s    = preg_replace( '@\x{00d0}@u'    , "D",    $s );    // Ð => D
      $s    = preg_replace( '@\x{0110}@u'    , "D",    $s );    // Ð => D
      $s    = preg_replace( '@\x{00f0}@u'    , "d",    $s );    // ð => d
      $s    = preg_replace( '@\x{0111}@u'    , "d",    $s );    // d => d
      $s    = preg_replace( '@\x{0126}@u'    , "H",    $s );    // H => H
      $s    = preg_replace( '@\x{0127}@u'    , "h",    $s );    // h => h
      $s    = preg_replace( '@\x{0131}@u'    , "i",    $s );    // i => i
      $s    = preg_replace( '@\x{0138}@u'    , "k",    $s );    // ? => k
      $s    = preg_replace( '@\x{013f}@u'    , "L",    $s );    // ? => L
      $s    = preg_replace( '@\x{0141}@u'    , "L",    $s );    // L => L
      $s    = preg_replace( '@\x{0140}@u'    , "l",    $s );    // ? => l
      $s    = preg_replace( '@\x{0142}@u'    , "l",    $s );    // l => l
      $s    = preg_replace( '@\x{014a}@u'    , "N",    $s );    // ? => N
      $s    = preg_replace( '@\x{0149}@u'    , "n",    $s );    // ? => n
      $s    = preg_replace( '@\x{014b}@u'    , "n",    $s );    // ? => n
      $s    = preg_replace( '@\x{00d8}@u'    , "O",    $s );    // Ø => O
      $s    = preg_replace( '@\x{00f8}@u'    , "o",    $s );    // ø => o
      $s    = preg_replace( '@\x{017f}@u'    , "s",    $s );    // ? => s
      $s    = preg_replace( '@\x{00de}@u'    , "T",    $s );    // Þ => T
      $s    = preg_replace( '@\x{0166}@u'    , "T",    $s );    // T => T
      $s    = preg_replace( '@\x{00fe}@u'    , "t",    $s );    // þ => t
      $s    = preg_replace( '@\x{0167}@u'    , "t",    $s );    // t => t

      // remove all non-ASCii characters
      $s    = preg_replace( '@[^\0-\x80]@u'    , "",    $s );

      // possible errors in UTF8-regular-expressions
      if (empty($s))
        return $original_string;
      else
        return $s;
    }

}
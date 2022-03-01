<?php

namespace ColoredTable;
use Colors\Color;

class Table {

    private $borderSet;
    private $c;
    
    # set of table
    private $tl;    # top left
    private $tb;    # top border
    private $tr;    # top right
    private $hd;    # header divide
    private $bl;    # body left
    private $br;    # body right
    private $bd;    # body divide
    private $bw;    # body wrapper
    private $dl;    # down left
    private $dr;    # down right
    private $db;    # down border
    private $wl;    # wrapper left
    private $wr;    # wrapper right
    private $hc;    # header cross
    private $bc;    # body cross
    private $htc;   # header top cross
    private $fc;    # footer cross
    private $fb;    # footer bottom

    /****************************************************************************
     *          < constructor >
     * descr.: constructor
     * return: void
     ****************************************************************************/
    public function __construct()
    {
        $this->tableSet(1);
    }

    /****************************************************************************
     *          < tableSet >
     * descr.: 
     * return: 
     ****************************************************************************/
    public function tableSet(int $set)
    {
        switch ($set) {
            case '1':
                $this->tl = '╔';
                $this->tb = '═';
                $this->tr = '╗';
                $this->hd = ' ║ ';    
                $this->bl = '║ ';    
                $this->bd = ' │ ';    
                $this->bw = '─';    
                $this->dl = '╚';    
                $this->dr = '╝';    
                $this->db = '═';
                $this->wl = '╠';
                $this->wr = '╣';
                $this->hc = '╬';
                $this->bc = '┼';
                $this->htc = '╦';
                $this->fc = '╩';
                $this->fb = '═';
                break;
            
            case '2':
                $this->tl = '+';
                $this->tb = '=';
                $this->tr = '+';
                $this->hd = ' | ';    
                $this->bl = '| ';    
                $this->bd = ' | ';    
                $this->bw = '-';    
                $this->dl = '+';    
                $this->dr = '+';    
                $this->db = '-';
                $this->wl = '+';
                $this->wr = '+';
                $this->hc = '+';
                $this->bc = '+';
                $this->htc = '=';
                $this->fc = '-';
                $this->fb = '-';
                break;

            default:
                $this->tl = '╔';
                $this->tb = '═';
                $this->tr = '╗';
                $this->hd = ' ║ ';    
                $this->bl = '║ ';    
                $this->bd = ' │ ';    
                $this->bw = '─';    
                $this->dl = '╚';    
                $this->dr = '╝';    
                $this->db = '═';
                $this->wl = '╠';
                $this->wr = '╣';
                $this->hc = '╬';
                $this->bc = '┼';
                $this->htc = '╦';
                $this->fc = '╩';
                $this->fb = '═';
                break;
        }
        return $this;
    }


    /****************************************************************************
     *          < mapLength >
     * descr.: map max. length of fields
     * return: array
     ****************************************************************************/
    private function mapLength(array $header, array $body): array
    {
        $mapLength = [];

        #map culumns
        foreach ($header[0] as $key=>$row) 
        {
            # map field from header
            $mapLength[] = strlen($row['text']);

            #map field from body
            foreach($body as $line)
            {
                if (strlen($line[$key]['text']) > $mapLength[$key]) $mapLength[$key] = strlen($line[$key]['text']);
            }
        }
        return $mapLength;
    }


    /****************************************************************************
     *          < make lines >
     * descr.: create lines (header/body) of table
     * return: COMMENT
     ****************************************************************************/
    private function makeLine(array $words, array $mapLength, $headerline = null, $isBody = false) 
    {
        global $c;
        $table = '';
        

        # enter the line
        foreach ($words as $key=>$line)
        {
            $table .= $this->bl;
            $wrapper = $this->wl. $this->tb;
            $secWrapper = $this->wl .$this->bw;
            $header = $this->tl .$this->tb;
            $footer = $this->dl .$this->fb;
            $wordCounter = 0;

            # read word by word
            foreach ($line as $word)
            {
                $wordCounter ++;
                $decoreWord = $word['text'] .$this->addSpace($word['text'], $mapLength[$wordCounter - 1]);
                $wrapper .= $this->addToWrapperSpace($decoreWord);
                $secWrapper .= $this->addToWrapperSpace($decoreWord, true);
                $header .= $this->addToWrapperSpace($decoreWord);
                $footer .= $this->addToWrapperSpace($decoreWord, false, true);

                if ($word['decoration'] != 0) 
                {
                    
                }

                switch ($word['decoration']) {
                    case '1':
                        $c = new Color();
                        $decoreWord = $c($decoreWord)->white()->bold()->highlight('green');
                        break;
                    case '2':
                        $c = new Color();
                        $decoreWord = $c($decoreWord)->white()->bold()->highlight('red');
                        break;
                    default:
                        
                        break;
                }
                
                if (($key == 0) && ($headerline != null))
                {
                    $wrap = $this->hd;
                }
                else
                {
                    $wrap = (($key == 0) && ($headerline != null) ? $this->hd : $this->bd);
                }
                
                if ($wordCounter == count($words[0])) $wrap = $this->hd;

                $table .= $decoreWord. ($wrap);
                $wrapper .= ($wordCounter == count($words[0]) ?  $this->wr : $this->hc .$this->tb);
                $secWrapper .= ($wordCounter == count($words[0]) ?  $this->wr : $this->bc .$this->bw);
                $header .= ($wordCounter == count($words[0]) ?  $this->tr : $this->htc .$this->tb);
                $footer .= ($wordCounter == count($words[0]) ?  $this->dr : $this->fc .$this->fb);
            }

            if (($key == 0) && ($headerline != null))
            {
                $table = $header .PHP_EOL .$table .PHP_EOL .$wrapper;
            }
            else
            {
                $table .= ($key == count($words) - 1 ? '' : PHP_EOL .$secWrapper);
            }

            $table .= PHP_EOL;

        }

        if ($isBody) $table .= $footer;

        return $table;
    }


    /****************************************************************************
     *          < add Space >
     * descr.: add space to table field
     * return: COMMENT
     ****************************************************************************/
    private function addSpace(string $word, int $fieldLength): string
    {
        $outStr = '';

        $spaceCount = $fieldLength - strlen($word);
        for ($i = 0; $i <= $spaceCount; $i++)
        {
            $outStr .= ' ';
        }
        return $outStr;
    }


    /****************************************************************************
     *          < add to wrapper space >
     * descr.: add space to wrapper
     * return: COMMENT
     ****************************************************************************/
    private function addToWrapperSpace($line, $oneline = false, $isFooter = false)
    {
        $out = '';
        $length = strlen($line);
        for ($i = 0; $i <= $length; $i++)
        {
            if ($isFooter) $out .= $this->fb;
            else $out .= ($oneline ? $this->bw : $this->tb);
        }
        return $out;
    }


    /****************************************************************************
     *          < createTable >
     * descr.: create final ASCII table
     * return: string
     ****************************************************************************/
    public function createTable(array $header, array $body): string
    {
        $mapLength = $this->mapLength($header, $body);
        $tabHeader = $this->makeLine($header, $mapLength, 1);
        $tabBody = $this->makeLine($body, $mapLength, null, 1);

        return $tabHeader .$tabBody;
    }

}


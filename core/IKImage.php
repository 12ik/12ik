<?php
defined ( 'IN_IK' ) or die ( 'Access Denied.' );
class IKImage {
	//图片类型
	var $type;
	//实际宽度
	var $width;
	//实际高度
	var $height;
	//改变后的宽度
	var $resize_width;
	//改变后的高度
	var $resize_height;
	//是否裁图
	var $cut;
	//源图象
	var $srcimg;
	//目标图象地址
	var $dstimg;
	//临时创建的图象
	var $im;
	//截图的x坐标位置
	var $srcX;
	//截图的y坐标位置
	var $srcY;
	//源图象的宽度
	var $srcW;
	//源图象的高度
	var $srcH;	
	//是否按比例截图
	var $isRatio;
	
	//构造函数
	public function __construct($img, $wid, $hei, $c, $dstpath,$srcX=0,$srcY=0, $srcW=0, $srcH=0, $isRatio=0) {
		$this->srcimg = $img;
		$this->resize_width = $wid;
		$this->resize_height = $hei;
		$this->cut = $c;
		//图片截取x和y坐标
		$this->srcX = $srcX;
		$this->srcY = $srcY;
		$this->srcW = $srcW;	
		$this->srcH = $srcH;	
		$this->isRatio = $isRatio;
		//图片的类型
		

		$this->type = strtolower ( substr ( strrchr ( $this->srcimg, "." ), 1 ) );
		
		//初始化图象
		$this->initi_img ();
		
		//目标图象地址
		$this->dst_img ( $dstpath );
		
		//--
		$this->width = imagesx ( $this->im );
		$this->height = imagesy ( $this->im );
		//生成图象
		$this->newimg ();
		ImageDestroy ( $this->im );
	}
	
	function newimg() {
		//改变后的图象的比例
		$resize_ratio = ($this->resize_width) / ($this->resize_height);
		//实际图象的比例
		$ratio = ($this->width) / ($this->height);
		if (($this->cut) == "1") //裁图
		{	
			if(($this->isRatio) == "1")
			{		//echo $this->srcX.'-'.$this->srcY.'-'.$this->srcW.'='.$this->resize_width.'+'.$this->resize_height;
					//指定 srcW 和 srcH 截图
					$newimg = imagecreatetruecolor ( $this->resize_width, $this->resize_height );
					//int imagecopyresampled ( resource dst_im, resource src_im, int dstX, int dstY, int srcX, int srcY, int dstW, int dstH, int srcW, int srcH)
					imagecopyresampled ( $newimg, $this->im, 0, 0, $this->srcX, $this->srcY, $this->resize_width, $this->resize_height, $this->srcW, $this->srcH);
					ImageJpeg ( $newimg, $this->dstimg );
				
			}else{
				if ($ratio >= $resize_ratio) //高度优先
				{
					$newimg = imagecreatetruecolor ( $this->resize_width, $this->resize_height );
					imagecopyresampled ( $newimg, $this->im, 0, 0, $this->srcX, $this->srcY, $this->resize_width, $this->resize_height, (($this->height) * $resize_ratio), $this->height );
					ImageJpeg ( $newimg, $this->dstimg );
				}
				if ($ratio < $resize_ratio) //宽度优先
				{
					$newimg = imagecreatetruecolor ( $this->resize_width, $this->resize_height );
					imagecopyresampled ( $newimg, $this->im, 0, 0, $this->srcX, $this->srcY, $this->resize_width, $this->resize_height, $this->width, (($this->width) / $resize_ratio) );
					ImageJpeg ( $newimg, $this->dstimg );
				}				
			}	
		} else //不裁图
		{
			if ($ratio >= $resize_ratio) {
				$newimg = imagecreatetruecolor ( $this->resize_width, ($this->resize_width) / $ratio );
				imagecopyresampled ( $newimg, $this->im, 0, $this->srcX, $this->srcY, 0, $this->resize_width, ($this->resize_width) / $ratio, $this->width, $this->height );
				ImageJpeg ( $newimg, $this->dstimg );
			}
			if ($ratio < $resize_ratio) {
				$newimg = imagecreatetruecolor ( ($this->resize_height) * $ratio, $this->resize_height );
				imagecopyresampled ( $newimg, $this->im, 0, $this->srcX, $this->srcY, 0, ($this->resize_height) * $ratio, $this->resize_height, $this->width, $this->height );
				ImageJpeg ( $newimg, $this->dstimg );
			}
		}
	}
	//初始化图象 By wanglijun 2012-4-10
	function initi_img() {
		$targetInfo = @getimagesize ( $this->srcimg );
		
		switch ($targetInfo ['mime']) {
			case 'image/jpeg' :
				$this->im = imagecreatefromjpeg ( $this->srcimg );
				break;
			case 'image/gif' :
				$this->im = imagecreatefromgif ( $this->srcimg );
				break;
			case 'image/png' :
				$this->im = imagecreatefrompng ( $this->srcimg );
				break;
			case 'image/bmp' :
				$this->im = imagecreatefromwbmp ( $this->srcimg );
				break;
		}
	
	}
	//图象目标地址
	function dst_img($dstpath) {
		
		$full_length = strlen ( $this->srcimg );
		
		$type_length = strlen ( $this->type );
		$name_length = $full_length - $type_length;
		
		$name = substr ( $this->srcimg, 0, $name_length - 1 );
		$this->dstimg = $dstpath;
	
		//echo $this->dstimg;
	

	}
}
<?php

namespace App\Model\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as IImage;
class Message extends Model
{

    protected $table = 'message';
    public $timestamps = false;
    protected $fillable = [
        'text',
        'insert_date',
        'user_id',
        'img',
    ];



    public function getText(): string
    {
        return $this->text;
    }
    public function setText(string $text)
    {
        $this->text = $text;
        return $this;
    }
    public function getMessageId(): int
    {
        return $this->messageId;
    }
    public function setMessageId(int $messageId): self
    {
        $this->messageId = $messageId;
        return $this;
    }
    public function getUser_id(): int
    {
        return $this->user_id;
    }
    public function setUser_id(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }
    public function getImg(): string
    {
        return $this->img;
    }
    public function setImg($img): self
    {
        $this->img = $img;
        return $this;
    }
    public function getInsertDate(): string
    {
        return $this->insert_date;
    }
    public function setInsertDate(string $insert_date): self
    {
        $this->insert_date = $insert_date;
        return $this;
    }
    public static function deleteMessage(int $messageId)
    {
        return self::destroy($messageId);
    }


    public function loadFile($file)
    {
        if (file_exists($file)) {
            $this->img = $this->genFileName();
            $filename = getcwd() . './img/' . $this->img;
            $image = IImage::make($file);
            $image->resize(200, null, function (\Intervention\Image\Constraint $constraint) {
                $constraint->aspectRatio();
            });
            var_dump(__DIR__);
            $image->text('Watermark', $image->getWidth() - 10, $image->getHeight() - 10, function (\Intervention\Image\AbstractFont $font) {
                $font->size(24);
                $font->file(__DIR__. '/arial.ttf');
                $font->color([255, 255, 255, 0.3]);
                $font->align('right');
                $font->valign('bottom');
            });

            $image->save($filename);
        }
    }

    public function genFileName()
    {
        return sha1(microtime(1) . mt_rand(1, 100000000)) . '.jpg';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getListMessages(int $limit = 10, int $offset = 0)
    {
        return self::with('user')
            ->limit($limit)
            ->offset($offset)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public static function getListUserMessages(int $user_id, int $limit = 20)
    {
        return self::query()->where('user_id', '=', $user_id)->limit($limit)->get();
    }

    public function getData()
    {
        return [
            'id' => $this->messageId,
            'text' => $this->text,
            'user_id' => $this->user_id,
            'insert_date' => $this->insert_date,
            'img' => $this->img
        ];
    }
}

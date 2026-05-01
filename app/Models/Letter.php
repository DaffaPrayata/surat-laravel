<?php

namespace App\Models;

use App\Enums\LetterType;
use App\Enums\Config as ConfigEnum;
use App\Helpers\LetterClassificationHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Letter extends Model
{
    use HasFactory;

    /**
     * AUTO SET KLASIFIKASI SAAT BUAT SURAT
     */
    protected static function booted()
    {
        static::creating(function ($letter) {
            if (empty($letter->classification_id)) {
                $letter->classification_id =
                    LetterClassificationHelper::byToday($letter->type);
            }
        });
    }

    protected $fillable = [
        'reference_number',  //jam pelajaran bisa sama,
        'agenda_number',     //kelas
        'from',
        'to',
        'letter_date',
        'received_date',
        'description',
        'note',
        'type',
        'classification_id',
        'user_id',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'received_date' => 'date',
    ];

    protected $appends = [
        'formatted_letter_date',
        'formatted_received_date',
        'formatted_created_at',
        'formatted_updated_at',
    ];

    /* ================= FORMAT TANGGAL ================= */

    public function getFormattedLetterDateAttribute(): string
    {
        return Carbon::parse($this->letter_date)->isoFormat('dddd, D MMMM YYYY');
    }

    public function getFormattedReceivedDateAttribute(): string
    {
        return Carbon::parse($this->received_date)->isoFormat('dddd, D MMMM YYYY');
    }

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->isoFormat('dddd, D MMMM YYYY, HH:mm:ss');
    }

    public function getFormattedUpdatedAtAttribute(): string
    {
        return $this->updated_at->isoFormat('dddd, D MMMM YYYY, HH:mm:ss');
    }

    /* ================= SCOPES ================= */

    public function scopeType($query, LetterType $type)
    {
        return $query->where('type', $type->type());
    }

    public function scopeIncoming($query)
    {
        return $this->scopeType($query, LetterType::INCOMING);
    }

    public function scopeOutgoing($query)
    {
        return $this->scopeType($query, LetterType::OUTGOING);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now());
    }

    public function scopeYesterday($query)
    {
        return $query->whereDate('created_at', now()->subDay());
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query, $find) {
            return $query
                ->where('reference_number', $find)
                ->orWhere('agenda_number', $find)
                ->orWhere('from', 'LIKE', $find . '%')
                ->orWhere('to', 'LIKE', $find . '%');
        });
    }

    public function scopeRender($query, $search)
    {
        return $query
            ->with(['attachments', 'classification'])
            ->search($search)
            ->latest('letter_date')
            ->paginate(Config::getValueByCode(ConfigEnum::PAGE_SIZE))
            ->appends(['search' => $search]);
    }

    public function scopeAgenda($query, $since, $until, $filter)
    {
        return $query->when($since && $until && $filter, function ($query) use ($since, $until, $filter) {
            return $query->whereBetween(DB::raw("DATE($filter)"), [$since, $until]);
        });
    }

    /* ================= RELATIONS ================= */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classification(): BelongsTo
    {
        return $this->belongsTo(Classification::class);
    }

    public function dispositions(): HasMany
    {
        return $this->hasMany(Disposition::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }
}

#!/usr/bin/env bash
#
# Check that each base file has .mov, .mp4, and .ogg versions in the folder.

missing=0

shopt -s nullglob
for file in *; do
  [[ ! -f "$file" ]] && continue

  base="${file%.*}"

  for ext in mov mp4 ogg; do
    if [[ ! -f "${base}.${ext}" ]]; then
      echo "❌ Missing ${base}.${ext} - creating..."
      # Find an existing source file to convert from
      for src_ext in mov mp4 ogg; do
        if [[ -f "${base}.${src_ext}" ]]; then
          ffmpeg -y -i "${base}.${src_ext}" "${base}.${ext}"
          echo "✅ Created ${base}.${ext} from ${base}.${src_ext}"
          break
        fi
      done
      # Still mark as missing if creation failed
      if [[ ! -f "${base}.${ext}" ]]; then
        missing=1
      fi
    fi
  done
done

if [[ $missing -eq 0 ]]; then
  echo "✅ All files have .mov, .mp4, and .ogg versions."
  exit 0
else
  echo "⚠️ Some files are missing required versions."
  exit 1
fi
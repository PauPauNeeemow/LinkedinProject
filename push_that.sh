if [ $# -eq 0 ]; then
  echo "Please provide a commit message as a parameter."
  exit 1
fi
git add .
commit_message="$1"
git commit -m "$commit_message"
git config --global credential.helper store
git push origin test

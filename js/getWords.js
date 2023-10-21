export async function getWords() {
  const response = await fetch("words.php");
  const result = await response.json();
  return result;
}

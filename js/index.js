import { getWords } from "./getWords.js";
import { startGame } from "./startGame.js";
import { $, element } from "./tools.js";

const buttonStart = $("#start");
buttonStart.addEventListener("click", init);

async function init() {
  let questionIndex = 1;
  const words = await getWords();
  const [$form, $p, $input, $indexContainer, $indexs] = startGame();

  setNewQuestion({ $p, question: words[questionIndex - 1] });

  $form.addEventListener("submit", (event) => {
    event.preventDefault();

    const form = new FormData(event.target);
    form.set("id", words[questionIndex - 1].id);
    $form.reset();

    fetch("verify-word.php", {
      method: "POST",
      credentials: "include",
      body: form,
    })
      .then((res) => res.json())
      .then((result) => console.log(result));
  });
}

function setNewQuestion({ $p, question }) {
  $p.textContent = question.word;
}
